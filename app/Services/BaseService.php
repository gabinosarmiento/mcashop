<?php

namespace App\Services;

abstract class BaseService
{
   // 5 minutes = 300
   protected function curl_request($url, $headers = [], $timeout = 30, $body = null, $method = 'GET'): array
   {
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

      if ($method === 'HEAD') {
         curl_setopt($ch, CURLOPT_NOBODY, true);
         curl_setopt($ch, CURLOPT_HEADER, true);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
      }

      if (in_array($method, ['POST'])) {
         curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
      }

      $request = curl_exec($ch);
      $error   = curl_error($ch);
      $code    = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);

      if ($request === false) {
         return ['error' => "Error conexión: {$error}"];
      }

      if (empty($request)) {
         return ['error' => 'No se recibió información de la API'];
      }

      if (in_array($code, [400, 401, 403, 404, 405, 408, 409, 410, 415, 422, 429, 500, 502, 503, 504])) {
         return ['error' => "Error HTTP {$code}", 'request' => $request];
      }

      return ['data' => $request];
   }

   protected function save_request(array $request, string $storage): array
   {
      $content = null;
      $data    = $request['data'];

      $decode = json_decode($data, true);

      if (json_last_error() === JSON_ERROR_NONE) {
         $content = json_encode($decode);
      }

      if (is_null($content)) {
         libxml_use_internal_errors(true);

         $decode = @simplexml_load_string($data);

         if ($decode !== false) {
            $content = json_encode($decode);
         }
      }

      if (is_null($content)) {
         return ['error' => 'Datos inválidos en la respuesta API'];
      }

      if (file_put_contents($storage, $content) === false) {
         return ['error' => 'No se pudo guardar el archivo'];
      }

      return ['message' => 'Archivo descargado correctamente'];
   }
}
