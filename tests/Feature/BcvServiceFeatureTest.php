<?php

namespace Laymont\VenezuelanForeignExchanges\Tests\Feature;

use GuzzleHttp\Exception\GuzzleException;
use Laymont\VenezuelanForeignExchanges\Services\BcvService;
use Laymont\VenezuelanForeignExchanges\Tests\TestCase;

class BcvServiceFeatureTest extends TestCase
{
    public function it_fetches_exchange_rates(): void
    {
        $this->markTestSkipped('Requires live BCV API');
    }

    public function it_returns_json_response(): void
    {
        $response = $this->getJson('/api/bcv');

        $response->assertStatus(200);
    }
}