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
     * Place whete to choose the parameters for requesting data.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
    public static function AirportAndDatesChooser(): array
    {
        $tripFrom = 'MAD';
        // $tripTo = 'AUH';
        $tripTo = 'FUE';
        $departDate = '2024-02-09';
        $returnDate = '2024-02-16';

        return ['tripFrom' => $tripFrom,
        'tripTo' => $tripTo,
        'departDate' => $departDate,
        'returnDate' => $returnDate
        ];
    }
}
