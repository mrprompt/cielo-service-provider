<?php

namespace MrPrompt\Cielo\Tests;

use Orchestra\Testbench\TestCase;
use MrPrompt\Cielo\CieloServiceProvider;

class CieloServiceProviderTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [CieloServiceProvider::class];
    }

    /**
     * Test if the configuration file is published.
     *
     * @define-env setCieloTestCars
     * @return void
     */
    public function testConfigurationIsPublished()
    {
        $this->artisan('vendor:publish', ['--provider' => CieloServiceProvider::class])
            ->assertExitCode(0);

        $this->assertFileExists(config_path('cielo.php'));
    }

    /**
     * Test if the Cielo binding is registered in the container.
     *
     * @return void
     */
    public function testCieloBindingIsRegistered()
    {
        config()->set('cielo.merchant_id', 'test-merchant-id');
        config()->set('cielo.merchant_key', 'test-merchant-key');
        config()->set('cielo.environment', 'sandbox');

        $this->assertInstanceOf(\MrPrompt\Cielo\Infra\HttpDriver::class, $this->app->make('cielo.driver'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\Bin\Consulta::class, $this->app->make('cielo.cartao.consulta.bin'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\Cartao\CancelamentoMerchantOrderId::class, $this->app->make('cielo.cartao.cancelamento.ordem'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\Cartao\CancelamentoPaymentId::class, $this->app->make('cielo.cartao.cancelamento.pagamento'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\Cartao\Captura::class, $this->app->make('cielo.cartao.captura'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\Cartao\Pagamento::class, $this->app->make('cielo.cartao.pagamento'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\Tokenizacao\Cartao::class, $this->app->make('cielo.tokenizacao.cartao'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\ZeroAuth\Cartao::class, $this->app->make('cielo.zeroauth.cartao'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\ZeroAuth\Carteira::class, $this->app->make('cielo.zeroauth.carteira'));
        $this->assertInstanceOf(\MrPrompt\Cielo\Recursos\ZeroAuth\Token::class, $this->app->make('cielo.zeroauth.token'));
    }
}