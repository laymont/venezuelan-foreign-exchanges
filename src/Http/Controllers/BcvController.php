<?php

namespace Laymont\VenezuelanForeignExchanges\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laymont\VenezuelanForeignExchanges\Services\BcvService;
class BcvController extends Controller
{
    public function __construct(protected BcvService $bcvService) {}

    /**
     * @throws GuzzleException
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->bcvService->getLatestExchangeRates();
        return response()->json($data);
    }
}
