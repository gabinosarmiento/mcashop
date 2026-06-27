<?php

namespace App\Services;

use App\Services\BaseService;

class SupplierCT extends BaseService
{
   // 0.47 aprox
   public function get_product($code): array
   {
      $data   = null;
      $result = $this->get_token();

      if (isset($result['error'])) {
         return $result;
      }

      $server  = "http://connect.ctonline.mx:3001/existencia/promociones/{$code}";
      $headers = ['Content-Type:application/json', "x-auth:{$result['token']}"];

      $request = $this->curl_request($server, $headers);

      if (isset($request['error'])) {
         return $request;
      }

      $decode = json_decode($request['data']);

      if (!isset($decode->almacenes)) {
         return ['error' => 'Datos inválidos en la respuesta de la API'];
      }

      $data['clave'] = $decode->codigo;
      $data['costo'] = floatval($decode->precio);

      if ($decode->moneda === 'USD') {
         $exchange = $this->get_exchange();

         if (isset($exchange['error'])) {
            return $exchange;
         }

         if (is_null($exchange['value'])) {
            return ['error' => 'Costo en USD sin tipo de cambio disponible'];
         }

         $data['costo'] = $data['costo'] * $exchange['value'];
      }

      foreach ($decode->almacenes as $store) {
         foreach ($store as $key => $value) {
            if ($key !== 'promocion') {
               $data['almacenes'][] = [
                  'clave'      => $key,
                  'existencia' => $value,
               ];
            }
         }
      }

      return ['data' => $data];
   }

   // 26.32s aprox
   public function get_inventory(): array
   {
      $result = $this->get_token();

      if (isset($result['error'])) {
         return $result;
      }

      $storage = storage_path('app/tmp/inventory_ct.json');
      $server  = 'http://connect.ctonline.mx:3001/existencia/promociones';
      $headers = ['Content-Type:application/json', "x-auth:{$result['token']}"];

      $request = $this->curl_request($server, $headers, 300);

      if (isset($request['error'])) {
         return $request;
      }

      $request = $this->save_request($request, $storage);

      return $request;
   }

   // 0.39s aprox
   public function get_exchange(): array
   {
      $result = $this->get_token();

      if (isset($result['error'])) {
         return $result;
      }

      $value   = null;
      $server  = 'http://connect.ctonline.mx:3001/pedido/tipoCambio';
      $headers = ['Content-Type:application/json', "x-auth:{$result['token']}"];

      $request = $this->curl_request($server, $headers);

      if (isset($request['error'])) {
         return $request;
      }

      $request = json_decode($request['data']);

      if (isset($request->tipoCambio)) {
         $value = $request->tipoCambio;
      }

      return ['value' => $value];
   }

   // 0.22s aprox
   private function get_token(): array
   {
      $token   = null;
      $server  = 'http://connect.ctonline.mx:3001/cliente/token';
      $headers = ['Content-Type:application/json'];
      $body    = json_encode(['email' => 'miraizos@mca-soluciones.com.mx', 'cliente' => 'OAX0334', 'rfc' => 'MCA940806HM8']);

      $request = $this->curl_request($server, $headers, 30, $body, 'POST');

      if (isset($request['error'])) {
         return $request;
      }

      $request = json_decode($request['data']);

      if (isset($request->token)) {
         $token = $request->token;
      }

      if (is_null($token)) {
         return ['error' => 'No se pudo obtener token de acceso'];
      }

      return ['token' => $token];
   }

   // 1.17s aprox
   public function get_products(): array
   {
      $storage = storage_path('app/tmp/products_ct.json');
      $remote  = 'catalogo_xml/productos.json';
      $server  = @ftp_connect('216.70.82.104');

      if ($server === false) {
         return ['error' => 'No se logró conectar al servidor FTP.'];
      }

      if (!@ftp_login($server, 'OAX0334', 'TZvfB7ykwr16uUrJ2bxF')) {
         ftp_close($server);

         return ['error' => 'No se logró autenticar en el servidor FTP.'];
      }

      if (!@ftp_pasv($server, true)) {
         ftp_close($server);

         return ['error' => 'No se logró activar el modo pasivo del FTP.'];
      }

      if (!@ftp_get($server, $storage, $remote, FTP_BINARY)) {
         ftp_close($server);

         return ['error' => 'No se logró descargar json del FTP.'];
      }

      ftp_close($server);

      return ['message' => 'Archivo descargado correctamente.'];
   }

}
