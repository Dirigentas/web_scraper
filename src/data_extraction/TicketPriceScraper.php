<?php

/**
 * Represents a class for extracting ticket prices from JSON data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

/**
 * Class TicketPriceScraper
 * Represents a class for extracting ticket prices from JSON data.
 */
class TicketPriceScraper
{
    /**
     * Extracts ticket prices from JSON data.
     * @param array $jsonData The JSON data containing ticket prices.
     * @return array[] An associative array where keys are recommendation IDs and values are corresponding ticket prices.
     */
    public static function ExtractTickedPrices(array $jsonData): Array
    {
        $prices = [];
        foreach ($jsonData['body']['data']['totalAvailabilities'] as $availablePrice) {
            $prices[$availablePrice['recommendationId']] = $availablePrice['total'];
        }
        return $prices;
    }
}
