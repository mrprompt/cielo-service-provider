<?php

namespace MrPrompt\Cielo;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use MrPrompt\Cielo\Infra\Ambiente;
use MrPrompt\Cielo\Infra\Autenticacao;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\Recursos\Bin\Consulta as ConsultaBin;
use MrPrompt\Cielo\Recursos\Cartao\CancelamentoMerchantOrderId;
use MrPrompt\Cielo\Recursos\Cartao\CancelamentoPaymentId;
use MrPrompt\Cielo\Recursos\Cartao\Captura;
use MrPrompt\Cielo\Recursos\Cartao\Pagamento;
use MrPrompt\Cielo\Recursos\Tokenizacao\Cartao as TokenizacaoCartao;
use MrPrompt\Cielo\Recursos\ZeroAuth\Cartao as ZeroAuthCartao;
use MrPrompt\Cielo\Recursos\ZeroAuth\Carteira as ZeroAuthCarteira;
use MrPrompt\Cielo\Recursos\ZeroAuth\Token as ZeroAuthToken;

class CieloServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $config_path = app()->basePath() . '/config/cielo.php';
        $this->publishes([
            __DIR__.'/config/config.php' => $config_path,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cielo.driver', function ($app) {
            $client = new Client;
            $ambiente = new Ambiente(config('cielo.environment'));
            $autenticacao = new Autenticacao(config('cielo.merchant_id'), config('cielo.merchant_key'));
            
            return new HttpDriver($ambiente, $client, $autenticacao);
        });

        $this->app->bind('cielo.cartao.consulta.bin', function($app) {
            return new ConsultaBin($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.cartao.cancelamento.ordem', function($app) {
            return new CancelamentoMerchantOrderId($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.cartao.cancelamento.pagamento', function($app) {
            return new CancelamentoPaymentId($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.cartao.captura', function($app) {
            return new Captura($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.cartao.pagamento', function($app) {
            return new Pagamento($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.tokenizacao.cartao', function($app) {
            return new TokenizacaoCartao($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.zeroauth.cartao', function($app) {
            return new ZeroAuthCartao($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.zeroauth.carteira', function($app) {
            return new ZeroAuthCarteira($this->app->get('cielo.driver'));
        });

        $this->app->bind('cielo.zeroauth.token', function($app) {
            return new ZeroAuthToken($this->app->get('cielo.driver'));
        });
    }
}
