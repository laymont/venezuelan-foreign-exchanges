<?php

namespace Laymont\VenezuelanForeignExchanges\Facades;

use Illuminate\Support\Facades\Facade;
use Laymont\VenezuelanForeignExchanges\Services\BcvService;

class VenezuelanForeignExchanges extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BcvService::class;
    }
}