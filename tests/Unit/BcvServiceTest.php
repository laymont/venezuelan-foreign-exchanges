<?php

namespace Laymont\VenezuelanForeignExchanges\Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Laymont\VenezuelanForeignExchanges\Concerns\BcvCurrencies;
use Laymont\VenezuelanForeignExchanges\Services\BcvService;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class BcvServiceTest extends TestCase
{
    /** @test */
    public function it_should_return_the_exchange_rates_from_bcv_currencies(): void
    {
        $mockedBcvCurrencies = Mockery::mock(BcvCurrencies::class, function (MockInterface $mock) {
            $mock->shouldReceive('getExchangeRates')->once()->andReturn([
                [
                    'date' => '2024-07-06',
                    'time' => '10:52',
                    'currency' => 'Euro',
                    'value' => 39.34,
                ],
                [
                    'date' => '2024-07-06',
                    'time' => '10:52',
                    'currency' => 'Yuan',
                    'value' => 5.05,
                ]
            ]);
        });


        $bcvService = new BcvService($mockedBcvCurrencies);
        $rates = $bcvService->getLatestExchangeRates();
        $this->assertIsArray($rates);
        $this->assertCount(2, $rates);
        $this->assertEquals('2024-07-06', $rates[0]['date']);
        $this->assertEquals('10:52', $rates[0]['time']);
        $this->assertEquals('Euro', $rates[0]['currency']);
        $this->assertEquals(39.34, $rates[0]['value']);
        $this->assertEquals('2024-07-06', $rates[1]['date']);
        $this->assertEquals('10:52', $rates[1]['time']);
        $this->assertEquals('Yuan', $rates[1]['currency']);
        $this->assertEquals(5.05, $rates[1]['value']);
    }
    /** @test */
    public function it_should_throw_exception_from_bcv_currencies(): void
    {
        $mockedBcvCurrencies = Mockery::mock(BcvCurrencies::class, function (MockInterface $mock) {
            $mock->shouldReceive('getExchangeRates')->once()->andThrow(new \RuntimeException('Test Exception'));
        });

        $bcvService = new BcvService($mockedBcvCurrencies);
        $this->expectException(\RuntimeException::class);
        $bcvService->getLatestExchangeRates();
    }
}
