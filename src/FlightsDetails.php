<?php

/**
 * File purpose is to read file data.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class FileReader reads data from the file.
 */
class FlightsDetails
{
    /**
     * @var array $airportsFrom An array containing the settings for flights details.
     * @var array $airportsTo An array containing the settings for flights details.
    */
    private $airportsFrom = ['MAD', 'JFK', 'CPH'];
    private $airportsTo = ['AUH', 'FUE', 'MAD'];
    // private $departureDates = 2024-02-02;
    // private $returnDates = $departureDate + 3;

    /**
     * Place whete to choose the parameters for requesting data.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
    public static function AirportAndDatesChooser(): array
    {
        $tripFrom = 'MAD';
        $tripTo = 'AUH';
        $departDate = '2024-02-02';
        $returnDate = '2024-02-09';

        return ['tripFrom' => $tripFrom,
        'tripTo' => $tripTo,
        'departDate' => $departDate,
        'returnDate' => $returnDate
        ];
    }
}
