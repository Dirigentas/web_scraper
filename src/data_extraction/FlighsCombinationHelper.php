<?php

/**
 * File purpose is 
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

use Aras\WebScraper\Formatting;

/**
 * Class ...
 */
class FlighsCombinationHelper
{
    /**
     * ...
     *
     * @param
     * @return
     */
    public static function CountDirectionFlights(array $flightsDetails, array $jsonData): Array
    {
        foreach ($jsonData['body']['data']['journeys'] as $journey) {
            foreach ($journey['flights'] as $flight) {

                if (
                    $flight['airportDeparture']['code'] == $flightsDetails['tripFrom']
                ) {
                    $directionCombinations[$journey['recommendationId']]['out'][] = $flight['number'];
                }
                if (
                    $flight['airportDeparture']['code'] == $flightsDetails['tripTo']
                ) {
                    $directionCombinations[$journey['recommendationId']]['in'][] = $flight['number'];
                }
            }
        }
        return $directionCombinations;
    }
}
