# laymont/venezuelan-foreign-exchanges

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laymont/venezuelan-foreign-exchanges.svg?style=flat-square)](https://packagist.org/packages/laymont/venezuelan-foreign-exchanges)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/laymont/venezuelan-foreign-exchanges/run-tests.yml?branch=main&label=tests)](https://github.com/laymont/venezuelan-foreign-exchanges/actions?query=workflow%3Arun-tests)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/laymont/venezuelan-foreign-exchanges/php-cs-fixer.yml?branch=main&label=code%20style)](https://github.com/laymont/venezuelan-foreign-exchanges/actions?query=workflow%3Aphp-cs-fixer)
[![Total Downloads](https://img.shields.io/packagist/dt/laymont/venezuelan-foreign-exchanges.svg?style=flat-square)](https://packagist.org/packages/laymont/venezuelan-foreign-exchanges)

Este paquete de Laravel proporciona una manera sencilla de obtener los tipos de cambio de divisas extranjeras de uso oficial en Venezuela, directamente desde la página del Banco Central de Venezuela (BCV).

## Funcionalidades

*   **Scraping del BCV:** Obtiene de forma automatizada los tipos de cambio desde la página del BCV.
*   **Tipos de Cambio:** Extrae los valores de cambio para las principales divisas de uso oficial en Venezuela (dólar, euro, yuan, lira, rublo).
*   **Formato de Datos:** Devuelve la fecha, la hora de la consulta, el nombre de la divisa y el valor en un formato array de fácil uso.

## Ventajas

*   **Fácil Integración:** Se integra fácilmente en cualquier proyecto Laravel.
*   **Datos Actualizados:** Obtiene los datos de cambio directamente de la fuente oficial, asegurando que sean lo más actualizados posibles.
*   **Centralización:** Centraliza la lógica para la obtención de datos, facilitando su uso y mantenimiento.
*   **Flexibilidad:** Devuelve los datos en un formato plano, lo cual es más flexible para integrarse en cualquier vista, API, etc.
*    **Hora de la Consulta**: Se incluye la hora de la consulta para mayor precisión.
*   **Testable**: Los servicios tienen pruebas unitarias.
*   **Autodescubrimiento**:  El paquete autodescubre el service provider de Laravel.

## Requisitos

*   PHP 8.2 o superior
*   Laravel 11 o superior

## Instalación

1.  **Añade el repositorio del paquete en tu `composer.json`**
    ```json
    "repositories": [
        {
            "type": "path",
            "url": "packages/Laymont/VenezuelanForeignExchanges"
        }
    ],
    ```
    Recuerda que `packages/Laymont/VenezuelanForeignExchanges` debe ser la ruta donde se encuentre el paquete en tu proyecto.

2.  **Instala el paquete via Composer:**
    ```bash
    composer require laymont/venezuelan-foreign-exchanges:@dev
    ```

3.  **Publicar la configuración del paquete (Opcional):**
    ```bash
     php artisan vendor:publish --tag=config
    ```
    Esto crea un archivo `config/bcv.php` donde puedes personalizar la url de la consulta.
4. **Configura las variables de entorno**  En el archivo `.env` de tu proyecto puedes definir la variable `BCV_URL`.

    ```env
    BCV_URL=https://www.bcv.org.ve/
    ```
## Cómo Usar el Paquete

Existen dos maneras principales de usar el paquete para obtener los datos de los tipos de cambio.

1.  **Acceder a la Ruta Web:**

    La manera más sencilla de obtener los tipos de cambio es visitando la ruta que el paquete define, abre tu navegador y visita la URL:

    ```
    http://tuproyecto.test/bcv/rates
    ```

Esto mostrará los tipos de cambio en formato JSON, reemplaza `http://tuproyecto.test` con la URL de tu proyecto.
2.  **Usar el servicio `BcvService` directamente en tu código:**
    Puedes usar el servicio directamente en tu controlador o en otra clase para tener mas control sobre la obtencion de datos.

    ```php
    <?php

    namespace App\Http\Controllers;

    use Laymont\VenezuelanForeignExchanges\Services\BcvService;

    class ExchangeController extends Controller
    {
        public function index(BcvService $bcvService)
        {
            $rates = $bcvService->getLatestExchangeRates();
            dd($rates);
        }
    }
    ```

    En este ejemplo, el método `getLatestExchangeRates()` de `BcvService` devuelve un array con los tipos de cambio,  el formato del array es el siguiente:

    ```php
       [
         [
           'date' => 'YYYY-MM-DD',
           'time' => 'HH:MM',
           'currency' => 'Nombre de la divisa',
           'value' => 123.45,
           ],
         ...
       ]
     ```
    Puedes usar este array en tu vista, api, etc.

## Contribuciones

Siéntete libre de hacer un fork de este proyecto y enviar un pull request con tus mejoras.

## Licencia

Este paquete tiene licencia bajo la [Licencia MIT](LICENSE.md).
