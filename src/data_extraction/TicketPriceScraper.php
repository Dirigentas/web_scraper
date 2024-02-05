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
     * @param array $decodedFlightsData The JSON data containing ticket prices.
     * @return array[] An associative array where keys are recommendation IDs and values are corresponding ticket prices.
     */
    public static function extractTickedPrices(array $decodedFlightsData): array
    {
        $prices = [];
        foreach ($decodedFlightsData['body']['data']['totalAvailabilities'] as $availablePrice) {
            $prices[$availablePrice['recommendationId']] = $availablePrice['total'];
        }
        return $prices;
    }

    /**
     * Finds the recommendation ID with the lowest price from decoded JSON data.
     *
     * array $jsonData Decoded JSON data containing flight options.
     * @return int|string The recommendation ID of the cheapest option.
     */
    public static function findCheapestRecommendation(array $jsonData): int|string
    {
        $cheapestRecommendationId;
        $lowestPrice = INF;

        foreach ($jsonData['body']['data']['totalAvailabilities'] as $option) {
            if ($lowestPrice > $option['total']) {
                $lowestPrice = $option['total'];
                $cheapestRecommendationId = $option['recommendationId'];
            }
        }
        return $cheapestRecommendationId;
    }
}
