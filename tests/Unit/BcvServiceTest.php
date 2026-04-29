<?php

/*
|--------------------------------------------------------------------------
| BcvService Unit Test
|--------------------------------------------------------------------------
*/

use Laymont\VenezuelanForeignExchanges\Concerns\BcvCurrencies;
use Laymont\VenezuelanForeignExchanges\Services\BcvService;
use Mockery\MockInterface;

describe('BcvService', function () {
    it('should return the exchange rates from bcv currencies', function () {
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

        expect($rates)->toBeArray()
            ->toHaveCount(2)
            ->and($rates[0]['date'])->toBe('2024-07-06')
            ->and($rates[0]['time'])->toBe('10:52')
            ->and($rates[0]['currency'])->toBe('Euro')
            ->and($rates[0]['value'])->toBe(39.34);
    });

    it('should throw exception from bcv currencies', function () {
        $mockedBcvCurrencies = Mockery::mock(BcvCurrencies::class, function (MockInterface $mock) {
            $mock->shouldReceive('getExchangeRates')->once()->andThrow(new RuntimeException('Test Exception'));
        });

        $bcvService = new BcvService($mockedBcvCurrencies);

        expect(fn () => $bcvService->getLatestExchangeRates())->toThrow(RuntimeException::class);
    });
});