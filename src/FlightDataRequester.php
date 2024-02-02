<?php

/**
 * Represents a class for managing requested flights
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Represents a class for managing requested flights
 */
class FlightDataRequester
{
    /**
      * @var array $FlightRequestParams An array containing parameters for requesting flight data:
      *                               - 'tripFrom': The departure airport code.
      *                               - 'tripTo': The arrival airport code.
      *                               - 'departDate': The departure date in 'YYYY-MM-DD' format.
      *                               - 'returnDate': The return date in 'YYYY-MM-DD' format.
      */
    public static $FlightRequestParams = [
        'tripFrom' => 'CPH',
        'tripTo' => 'MAD',
        'departDate' => '2024-02-09',
        'returnDate' => '2024-02-16'
    ];
}
