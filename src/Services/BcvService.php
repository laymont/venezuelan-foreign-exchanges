<?php

namespace Laymont\VenezuelanForeignExchanges\Services;

use GuzzleHttp\Exception\GuzzleException;
use Laymont\VenezuelanForeignExchanges\Concerns\BcvCurrencies;

class BcvService
{
    protected BcvCurrencies $bcvCurrencies;

    public function __construct(BcvCurrencies $bcvCurrencies)
    {
        $this->bcvCurrencies = $bcvCurrencies;
    }

    /**
     * @throws GuzzleException
     */
    public function getLatestExchangeRates(): array
    {
        return $this->bcvCurrencies->getExchangeRates();
    }
}
