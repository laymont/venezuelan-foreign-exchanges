<?php

use Illuminate\Support\Facades\Route;
use Laymont\VenezuelanForeignExchanges\Http\Controllers\BcvController;

Route::get('/bcv/rates', [BcvController::class, 'index']);
