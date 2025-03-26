<?php

namespace MrPrompt\CieloLaravel\Tests;

use Orchestra\Testbench\TestCase;
use MrPrompt\CieloLaravel\CieloServiceProvider;

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
        $merchantId = 'test-merchant-id';
        $merchantKey = 'test-merchant-key';
        $environment = 'sandbox';

        config()->set('cielo.merchant_id', $merchantId);
        config()->set('cielo.merchant_key', $merchantKey);
        config()->set('cielo.environment', $environment);

        $cielo = $this->app->make('cielo');

        $this->assertInstanceOf(\stdClass::class, $cielo);
        // $this->assertEquals($merchantId, $cielo->getMerchantId());
        // $this->assertEquals($merchantKey, $cielo->getMerchantKey());
        // $this->assertEquals($environment, $cielo->getEnvironment());
    }
}