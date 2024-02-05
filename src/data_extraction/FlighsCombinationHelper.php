<?php

/**
 * Represents a class for counting flight directions based on provided flight details in JSON data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

/**
 * Class FlighsCombinationHelper
 * Represents a class for counting flight directions based on provided flight details in JSON data.
 */
class FlighsCombinationHelper
{
    /**
     * This method analyzes the JSON data containing flight details and counts the number of unique flight paths for each direction.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data.
     * @param string $searchId String containing ID of the current search.
     * @param array $decodedFlightsData The JSON file containing data of selected airports and period.
     * @return array[] An associative array where keys are recommendation IDs and values are arrays containing flight numbers for outbound and inbound directions.
     */
    public static function countDirectionFlights(array $formattedSearchCriteria, string $searchId, array $decodedFlightsData): array
    {
        foreach ($decodedFlightsData['body']['data']['journeys'] as $journey) {
            foreach ($journey['flights'] as $flight) {
                if (
                    $flight['airportDeparture']['code'] == $formattedSearchCriteria[$searchId]['tripFrom']
                ) {
                    $directionCombinations[$journey['recommendationId']]['out'][] = $flight['number'];
                }
                if (
                    $flight['airportDeparture']['code'] == $formattedSearchCriteria[$searchId]['tripTo']
                ) {
                    $directionCombinations[$journey['recommendationId']]['in'][] = $flight['number'];
                }
            }
        }
        return $directionCombinations;
    }
}
