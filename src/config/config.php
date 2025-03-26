<?php

return [

    'merchant_id'  => env('CIELO_MERCHANT_ID', ''),
    'merchant_key' => env('CIELO_MERCHANT_KEY', ''),
    'environment'  => env('CIELO_ENV', 'producao'), // producao | sandbox

];
