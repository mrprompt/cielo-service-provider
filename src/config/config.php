<?php

return [

    'merchant_id'  => env('CIELO_MERCHANT_ID', 'cielo-merchant-id'),
    'merchant_key' => env('CIELO_MERCHANT_KEY', 'cielo-merchant-key'),
    'environment'  => env('CIELO_ENV', 'sandbox'), // producao | sandbox

];
