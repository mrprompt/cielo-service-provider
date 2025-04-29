# Provider Laravel para API Cielo

[![Tests](https://github.com/mrprompt/cielo-service-provider/actions/workflows/tests.yml/badge.svg)](https://github.com/mrprompt/cielo-service-provider/actions/workflows/tests.yml)

## Descrição

## Instalação

Via Composer: `composer require mrprompt/cielo-laravel-provider`

### Laravel

Incluir o código abaixo na posição `providers` no arquivo `config/app.php`

```php
(...)

   'providers' => [

    (...)

        /*
         * Package Service Providers...
         */

        // Cielo
        MrPrompt\Cielo\CieloServiceProvider::class,

    (...)

    ],

(...)
```

Executar `php artisan vendor:publish` no projeto.

### Lumen

Criar o arquivo `config/cielo.php`:

```php
<?php

return [

    'merchant_id'  => $_ENV['CIELO_MERCHANT_ID'],
    'merchant_key' => $_ENV['CIELO_MERCHANT_KEY'],
    'environment'  => $_ENV['CIELO_ENV'], // producao | sandbox

];

```

Incluir o código abaixo em `bootstrap/app.php`:

```php
(...)

$app->configure('cielo');
$app->register(MrPrompt\Cielo\CieloServiceProvider::class);

(...)
```

## Configuração

As variáveis de ambiente `CIELO_MERCHANT_ID`, `CIELO_MERCHANT_KEY` e `CIELO_ENV` deverão ser configuradas no arquivo `.env`.

Os valores aceitos para `CIELO_ENV` são:

- `sandbox`
- `producao`

Ex.:

```plain
CIELO_MERCHANT_ID=123435678
CIELO_MERCHANT_KEY=25fbb99341c739dd84a7b06ec78c2cac718838630f30b182d033ce2e621c34f3
CIELO_ENV=sandbox
```

Como alternativa, após `vendor:publish`, as configurações poderão ser incluídas diretamente no arquivo de configuração `config/cielo.php`.

