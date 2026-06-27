<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Models\ErrorModel;
use App\Models\MarkupModel;
use App\Models\ProductInventoryModel;
use App\Models\ProductRelationModel;
use App\Models\SupplierStoreModel;
use App\Services\SupplierCVAII;
use Exception;
use DB;

class InventoryCVA extends BaseCommand
{
   /**
    * The ID of the supplier associated with this command.
    *
    * @var int
    */
   protected $supplier = 7;

   /**
    * The label of the console command.
    *
    * @var string
    */
   protected $label = 'Inventario CVA';

   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'inventory:cva {id?}';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Este proceso descarga nuevas existencias del proveedor CVA';

   /**
    * Execute the console command.
    *
    * @return mixed
    */
   public function handle(): int
   {
      $id = $this->argument('id');

      $command = $this->startCommand($id, 'Descargando inventario');

      $supplier = new SupplierCVAII();

      // $service = $supplier->get_inventory();

      // $this->serviceCommand($command, $service, 'Analizando respuesta del servicio inventario');

      $storage = storage_path('app/private/inventory_cva.json');

      if (!file_exists($storage)) {
         $this->stopCommand($command, "No se encontró el archivo en la ruta {$storage}");
      }

      $json = file_get_contents($storage);

      $data = json_decode($json, true);

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

            foreach ($data['item'] as $item) {
               if ($relation['code'] == str_clean($item['clave'])) {
                  $storage = $this->storage($item);

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
                           $create['zc']        = $storage['zc'];
                           $create['stock']     = $storage['stock'];
                           $create['location']  = $storage['location'];
                           $create['cost']      = floatval($item['precio']);

                           if (isset($item['PrecioDescuento'])) {
                              $discount_price = floatval($item['PrecioDescuento']);

                              if ($discount_price > 0) {
                                 $create['cost'] = $discount_price;
                              }
                           }

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
    *
    * Return the store with the highest stock (includes 'disponible' as OAXACA).
    *
    * @param  array  $item
    * @return array
    */
   private function storage(array $stocks): ?array
   {
      $result = null;
      $stores = SupplierStoreModel::where('supplier_id', $this->supplier)->get()->toArray();

      foreach ($stores as $store) {
         if (isset($stocks[$store['code']])) {
            $quantity = intval($stocks[$store['code']]);

            if (is_null($result) || $quantity > $result['stock']) {
               $result = ['stock' => $quantity, 'zc' => $store['zc'], 'location' => $store['location']];
            }
         }
      }

      return $result;
   }
}
