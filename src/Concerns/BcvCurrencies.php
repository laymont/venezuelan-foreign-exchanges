<?php

namespace Laymont\VenezuelanForeignExchanges\Concerns;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class BcvCurrencies
{
    protected string $url;

    protected array $data;

    public Client $client;
    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.134 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Connection' => 'keep-alive',
            ],
            'verify' => false, //base_path('certs/cacert.pem'), // Asegúrate de tener configurado el certificado o elimina esta línea si es necesario
        ]);
        $this->url = config('bcv.url');
    }
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getExchangeRates(): array
    {
        $response = $this->client->get($this->url);

        if ($response->getStatusCode() !== 200) {
            Log::error('Error al acceder a la página del BCV');
            throw new \RuntimeException('Error al acceder a la página del BCV');
        }

        $html = (string) $response->getBody();
        $crawler = new Crawler($html);

        $exchangeRates = [];

        // Obtener la fecha y la hora
        $date_time = $this->parseDateAndTime($crawler);
        $fecha = $date_time['date'];
        $hora = $date_time['time'];

        // Iterar sobre cada div con un id de divisa (euro, yuan, lira, rublo, dolar)
        $divisas_ids = ['euro', 'yuan', 'lira', 'rublo', 'dolar'];
        foreach ($divisas_ids as $id_divisa) {
            $contenedorDivisa = $crawler->filter("#{$id_divisa}");

            // Verificar si el contenedor de la divisa fue encontrado
            if ($contenedorDivisa->count() === 0) {
                Log::error("No se encontró el contenedor de la divisa {$id_divisa}.");

                continue;  // Saltar a la siguiente divisa
            }

            // Obtener el nombre de la divisa a partir del span
            $nombreDivisa = trim($contenedorDivisa->filter('span')->first()->text());

            // Obtener el valor de la divisa desde el strong
            $valorDivisa = trim($contenedorDivisa->filter('div.centrado strong')->text());
            // Reemplace la coma por un punto para poder convertir a float
            $valorDivisa = (float) str_replace(',', '.', $valorDivisa);


            $exchangeRates[] = [
                'date' => $fecha,
                'time' => $hora,
                'currency' => $nombreDivisa,
                'value' => $valorDivisa,
            ];
        }

        return $exchangeRates;
    }

    /**
     * @param Crawler $crawler
     * @return array
     */
    private function parseDateAndTime(Crawler $crawler): array
    {
        $fechaTexto = $crawler->filter('div.pull-right.dinpro.center span.date-display-single')->attr('content');
        $fecha = Carbon::parse($fechaTexto)->toDateString();
        $fullText = $crawler->filter('div.pull-right.dinpro.center')->text();
        preg_match('/(\d{1,2}:\d{2}) (am|pm)/i', $fullText, $matches);
        if (isset($matches[1]) && isset($matches[2])) {
            $time = date('H:i', strtotime($matches[1] . $matches[2]));
        } else {
            $time = date('H:i');
        }
        return ['date' => $fecha, 'time' => $time];
    }
}
