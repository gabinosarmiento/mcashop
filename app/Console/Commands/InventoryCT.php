<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Models\ErrorModel;
use App\Models\MarkupModel;
use App\Models\ProductInventoryModel;
use App\Models\ProductRelationModel;
use App\Models\SupplierStoreModel;
use App\Services\SupplierCT;
use Exception;
use DB;

class InventoryCT extends BaseCommand
{
   /**
    * The ID of the supplier associated with this command.
    *
    * @var int
    */
   protected $supplier = 4;

   /**
    * The label of the console command.
    *
    * @var string
    */
   protected $label = 'Inventario CT';

   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'inventory:ct {id?}';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Este proceso descarga nuevas existencias del proveedor CT';

   /**
    * Execute the console command.
    *
    * @return mixed
    */
   public function handle(): int
   {
      $id = $this->argument('id');

      $command = $this->startCommand($id, 'Descargando inventario');

      $supplier = new SupplierCT();

      $exchange = $supplier->get_exchange();

      $service = $supplier->get_inventory();

      $this->serviceCommand($command, $service, 'Analizando respuesta del servicio inventario');

      $storage = storage_path('app/tmp/inventory_ct.json');

      if (!file_exists($storage)) {
         $this->stopCommand($command, "No se encontró el archivo en la ruta {$storage}");
      }

      $json = file_get_contents($storage);

      $items = json_decode($json, true);

      $relations = ProductRelationModel::where('supplier_id', $this->supplier)->get();

      $this->total = count($relations);

      $this->logCommand($command, "{$this->total} registros a procesar");

      foreach ($relations as $relation) {
         $this->checkCommand($command);

         try {
            DB::beginTransaction();

            $processed = false;

            $update['created']     = date('Y-m-d');
            $update['relation_id'] = $relation['id'];

            foreach ($items as $item) {
               if ($relation['code'] === str_clean($item['codigo'])) {
                  $item['cost'] = floatval($item['precio']);

                  if ($item['moneda'] === 'USD') {
                     if (!isset($exchange['value'])) {
                        $this->logCommand($command, "Relación {$relation['id']} omitida", 'Relación omitida por tipo de cambio no disponible', 'notice');

                        break;
                     }

                     $item['cost'] = round($item['cost'] * $exchange['value'], 2);
                  }

                  $storage = $this->storage($item['almacenes']);

                  if (!is_null($storage)) {
                     if (intval($storage['stock']) > 0) {
                        if (floatval($item['precio']) > 0) {
                           $create['price']     = null;
                           $create['special']   = null;
                           $create['promotion'] = null;
                           $create['available'] = null;
                           $create['slogan']    = null;
                           $create['launch']    = null;
                           $create['expire']    = null;
                           $create['cost']      = $item['cost'];
                           $create['zc']        = $storage['zc'];
                           $create['stock']     = $storage['stock'];
                           $create['location']  = $storage['location'];

                           $markup = MarkupModel::where('base', '<=', ceil($create['cost']))->where('bound', '>=', ceil($create['cost']))->first();

                           if (is_null($markup)) {
                              $this->logCommand($command, "Relación {$relation['id']} omitida", "Relación sin margen de utilidad para precio {$create['cost']}", 'notice');

                              break;
                           }

                           $create['markup'] = $markup->margin;
                           $create['price']  = round(markup_buildup($create['cost'], $create['markup']), 2);
                           $create['price']  = round(iva_buildup($create['price']), 2);

                           ProductInventoryModel::updateOrCreate($update, $create);

                           $processed = true;
                        }
                     }
                  }

                  break;
               }
            }

            if ($processed === false) {
               $inventory = ProductInventoryModel::firstWhere($update);

               if (!is_null($inventory)) {
                  $inventory->update(['stock' => 0]);
               }
            }

            DB::commit();
         } catch (Exception $exception) {
            DB::rollBack();

            $this->errors++;

            ErrorModel::create(['tag' => $relation['id'], 'reference' => $this->name, 'exception' => $exception]);

            $this->logCommand($command, "Error en relación {$relation['id']}", $exception->getMessage(), 'error');
         }
      }

      $this->completeCommand($command);

      return self::SUCCESS;
   }

   /**
    * Get the store with the highest storage.
    *
    * @param  array  $stores
    * @return array|null
    */
   private function storage(array $stocks): ?array
   {
      $result = null;
      $stores = SupplierStoreModel::where('supplier_id', $this->supplier)->get()->toArray();

      foreach ($stocks as $stock) {
         unset($stock['promocion']);

         $key      = key($stock);
         $quantity = intval($stock[$key]);

         if (is_null($result) || $quantity > $result['stock']) {
            foreach ($stores as $store) {
               if ($store['code'] == $key) {
                  $result = ['stock' => $quantity, 'zc' => $store['zc'], 'location' => $store['location']];
               }
            }
         }
      }

      return $result;
   }
}