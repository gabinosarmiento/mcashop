<?php
if (!function_exists('discount_breakdown')) {
    function discount_breakdown($price, $discount)
    {
        return $price * (1 - ($discount / 100));
    }
}
if (!function_exists('discount_calculate')) {
    function discount_calculate($price, $discount)
    {
        return $price * ($discount / 100);
    }
}
if (!function_exists('iva_breakdown')) {
    function iva_breakdown($cantidad)
    {
        return $cantidad / (1 + TAX['rate']);
    }
}

if (!function_exists('iva_buildup')) {
    function iva_buildup($cantidad)
    {
        return $cantidad * (1 + TAX['rate']);
    }
}

if (!function_exists('iva_calculate')) {
    function iva_calculate($cantidad)
    {
        return $cantidad * TAX['rate'];
    }
}

if (!function_exists('markup_buildup')) {
    function markup_buildup($costo, $margen)
    {
        return $costo / (1 - ($margen / 100));
    }
}

if (!function_exists('markup_breakdown')) {
    function markup_breakdown($venta, $costo)
    {
        return (($venta - $costo) / $venta) * 100;
    }
}

if (!function_exists('surcharge_buildup')) {
    function surcharge_buildup($price, $surcharge)
    {
        return $price * (1 + ($surcharge / 100));
    }
}

if (!function_exists('str_folio')) {
    function str_folio($value, $prefix = '')
    {
        return $prefix . str_pad($value + 1, 10, 0, STR_PAD_LEFT);
    }
}

if (!function_exists('str_clean')) {
   function str_clean($value, $strict = false)
   {
      if (is_string($value)) {
         # Normalize line breaks, tabs and unicode spaces.
         $value = preg_replace('/[\r\n\t\x{00A0}]+/u', ' ', $value);

         # Apply flexible cleanup preserving readable content.
         $value = preg_replace('/[^\p{L}\p{N}\s\.\,\-\_\#\(\)\'"\/\&]/u', '', $value);

         # Apply aggressive cleanup for storage-safe values.
         if ($strict === true) {
            $value = preg_replace('/[^a-zA-Z0-9_\-\.\+]/', '', $value);
         }

         # Normalize duplicated spaces.
         $value = preg_replace('/ +/u', ' ', $value);

         return trim($value);
      }

      return $value;
   }
}

if (!function_exists('array_unwrap')) {

    function array_unwrap($array, $extract = [])
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (in_array($key, $extract, true) && is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $result[$subKey] = $subValue;
                }
                continue;
            }

            if (!is_array($value)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}

if (!function_exists('number_text')) {
    function number_text($amount): string
    {
        $amount = number_format((float) $amount, 2, '.', '');

        [$integer, $decimal] = explode('.', $amount);

        $words = function ($number) use (&$words) {
            $units = [
                0  => 'cero',
                1  => 'un',
                2  => 'dos',
                3  => 'tres',
                4  => 'cuatro',
                5  => 'cinco',
                6  => 'seis',
                7  => 'siete',
                8  => 'ocho',
                9  => 'nueve',
                10 => 'diez',
                11 => 'once',
                12 => 'doce',
                13 => 'trece',
                14 => 'catorce',
                15 => 'quince',
                16 => 'dieciséis',
                17 => 'diecisiete',
                18 => 'dieciocho',
                19 => 'diecinueve',
                20 => 'veinte',
                21 => 'veintiún',
                22 => 'veintidós',
                23 => 'veintitrés',
                24 => 'veinticuatro',
                25 => 'veinticinco',
                26 => 'veintiséis',
                27 => 'veintisiete',
                28 => 'veintiocho',
                29 => 'veintinueve',
            ];

            $tens = [
                30 => 'treinta',
                40 => 'cuarenta',
                50 => 'cincuenta',
                60 => 'sesenta',
                70 => 'setenta',
                80 => 'ochenta',
                90 => 'noventa',
            ];

            $hundreds = [
                100 => 'cien',
                200 => 'doscientos',
                300 => 'trescientos',
                400 => 'cuatrocientos',
                500 => 'quinientos',
                600 => 'seiscientos',
                700 => 'setecientos',
                800 => 'ochocientos',
                900 => 'novecientos',
            ];

            if ($number < 30) {
                return $units[$number];
            }

            if ($number < 100) {
                $ten  = floor($number / 10) * 10;
                $unit = $number % 10;

                return $unit ? $tens[$ten] . ' y ' . $units[$unit] : $tens[$ten];
            }

            if ($number < 1000) {
                $hundred = floor($number / 100) * 100;
                $rest    = $number % 100;

                if (!$rest) {
                    return $hundreds[$hundred];
                }

                return ($hundred == 100 ? 'ciento' : $hundreds[$hundred]) . ' ' . $words($rest);
            }

            if ($number < 1000000) {
                $thousand = floor($number / 1000);
                $rest     = $number % 1000;

                $text = $thousand == 1 ? 'mil' : $words($thousand) . ' mil';

                return $rest ? $text . ' ' . $words($rest) : $text;
            }

            $million = floor($number / 1000000);
            $rest    = $number % 1000000;

            $text = $million == 1 ? 'un millón' : $words($million) . ' millones';

            return $rest ? $text . ' ' . $words($rest) : $text;
        };

        $text     = $words((int) $integer);
        $currency = (int) $integer === 1 ? 'peso' : 'pesos';

        return ucfirst($text . ' ' . $currency . ' ' . $decimal . '/100 M.N.');
    }
}
