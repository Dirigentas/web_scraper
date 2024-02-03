<?php

/**
 * Represents a class for counting flight directions based on provided flight details in JSON data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

use Aras\WebScraper\Formatting;

/**
 * Class FlighsCombinationHelper
 * Represents a class for counting flight directions based on provided flight details in JSON data.
 */
class FlighsCombinationHelper
{
    /**
     * This method analyzes the JSON data containing flight details and counts the number of flights for each direction
     * (outbound and inbound) based on the provided flight details.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data.
     * @param array $jsonData The JSON file containing data of selected airports and period.
     * @return array[] An associative array where keys are recommendation IDs and values are arrays containing flight numbers for outbound and inbound directions.
     */
    public static function CountDirectionFlights(array $formattedSearchCriteria, array $jsonData): Array
    {
        foreach ($jsonData['body']['data']['journeys'] as $journey) {
            foreach ($journey['flights'] as $flight) {

                if (
                    $flight['airportDeparture']['code'] == $formattedSearchCriteria['tripFrom']
                ) {
                    $directionCombinations[$journey['recommendationId']]['out'][] = $flight['number'];
                }
                if (
                    $flight['airportDeparture']['code'] == $formattedSearchCriteria['tripTo']
                ) {
                    $directionCombinations[$journey['recommendationId']]['in'][] = $flight['number'];
                }
            }
        }
        return $directionCombinations;
    }
}