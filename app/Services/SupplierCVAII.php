<?php

namespace App\Services;

use App\Services\BaseService;

class SupplierCVAII extends BaseService
{
   // 4.11s aprox
   public function get_product($code): array
   {
      $data    = null;
      $server  = "http://www.grupocva.com/catalogo_clientes_xml/lista_precios.xml?cliente=7783&clave={$code}&sucursales=1&MonedaPesos=1";
      $headers = ['Content-Type: application/xml', 'Accept: application/xml'];

      $request = $this->curl_request($server, $headers);

      if (isset($request['error'])) {
         return $request;
      }

      libxml_use_internal_errors(true);

      $decode = simplexml_load_string($request['data']);

      if ($decode === false) {
         return ['error' => 'Datos inválidos en la respuesta de la API'];
      }

      $decode = json_decode(json_encode($decode));

      $items = $decode->item;

      if (!is_array($items)) {
         $items = [$items];
      }

      foreach ($items as $item) {
         if ($item->clave == $code) {
            $data['almacenes'] = [];
            $data['clave']     = $item->clave;
            $data['costo']     = floatval($item->precio);

            $itemArray = json_decode(json_encode($item), true);

            foreach ($itemArray as $key => $value) {
               $data['almacenes'][] = [
                  'clave'      => $key,
                  'existencia' => intval($value),
               ];
            }

            break;
         }
      }

      return ['data' => $data];
   }

   public function get_products(): array
   {
      $storage = storage_path('app/tmp/products_cva.json');
      $server  = 'http://www.grupocva.com/catalogo_clientes_xml/lista_precios.xml?cliente=7783&MonedaPesos=1';
      $headers = ['Content-Type: application/xml', 'Accept: application/xml'];

      $request = $this->curl_request($server, $headers, 300);

      if (isset($request['error'])) {
         return $request;
      }

      $save = $this->save_request($request, $storage);

      return $save;
   }

   public function get_inventory(): array
   {
      $storage = storage_path('app/tmp/inventory_cva.json');
      $server  = 'http://www.grupocva.com/catalogo_clientes_xml/lista_precios.xml?cliente=7783&MonedaPesos=1&sucursales=1&promos=1';
      $headers = ['Content-Type: application/xml', 'Accept: application/xml'];

      $request = $this->curl_request($server, $headers, 480);

      if (isset($request['error'])) {
         return $request;
      }

      $save = $this->save_request($request, $storage);

      return $save;
   }

   private function formatter($data):  ? array
   {
      $result = null;
      $stores = json_decode($data);

      if (isset($stores->item)) {
         $stores = reset($stores);

         $result = ['clave' => $stores->clave, 'costo' => $stores->precio];

         foreach ($stores as $key => $store) {
            $result['almacenes'][] = ['clave' => $key, 'existencia' => $store];
         }
      }

      return $result;
   }
}
