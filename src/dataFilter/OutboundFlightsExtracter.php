<?php

/**
 * File purpose is to extract outbound  and  inbound  flights data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\dataFilter;

use Aras\WebScraper\Formatting;

/**
 * Class ...
 */
class OutboundFlightsExtracter
{
    /**
     * ...
     *
     * @param
     * @return
     */
    public static function ExtractOutbound1Flights(array $flightsDetails, array $jsonData, array $filteredDataArray, array $tickedPrices): Array
    {
        $directionCombinations = [];
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
        foreach ($directionCombinations as $key => $recommendationId) {
            $inboundCombinationsCountSingleId = count($recommendationId['in']);
            foreach ($jsonData['body']['data']['journeys'] as $journey) {
                foreach ($journey['flights'] as $flight) {
                    foreach (range(1, $inboundCombinationsCountSingleId) as $number) {
                        if (
                            $flight['airportDeparture']['code'] == $flightsDetails['tripFrom'] &&
                            $journey['recommendationId'] == $key
                        ) {
        
                            $filteredDataArray['Price'][] = $tickedPrices[$journey['recommendationId']];
                            
                            $filteredDataArray['Taxes'][] = $journey['importTaxAdl'];
        
                            $filteredDataArray['outbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['outbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['outbound 1 time departure'][] = Formatting::formatDate($flight['dateDeparture']);
                            $filteredDataArray['outbound 1 time arrival'][] = Formatting::formatDate($flight['dateArrival']);
                            $filteredDataArray['outbound 1 flight number'][] = $flight['companyCode'] . $flight['number'];
                        }
                    }
                }
            }
        }
        return $filteredDataArray;
    }

     /**
     * ...
     *
     * @param
     * @return
     */
    public static function ExtractOutbound2Flights(array $flightsDetails, array $jsonData, array $filteredDataArray, array $tickedPrices): Array
    {
        $directionCombinations = [];
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
        foreach ($directionCombinations as $key => $recommendationId) {
            $inboundCombinationsCountSingleId = count($recommendationId['in']);
            foreach (range(1, $inboundCombinationsCountSingleId) as $number) {
                foreach ($jsonData['body']['data']['journeys'] as $journey) {
                    foreach ($journey['flights'] as $flight) {
        
                        if (
                            $flight['airportDeparture']['code'] != $flightsDetails['tripFrom'] &&
                            $flight['airportArrival']['code'] == $flightsDetails['tripTo'] &&
                            $journey['recommendationId'] == $key
                        ) {        
                            $filteredDataArray['outbound 2 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['outbound 2 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['outbound 2 time departure'][] = Formatting::formatDate($flight['dateDeparture']);
                            $filteredDataArray['outbound 2 time arrival'][] = Formatting::formatDate($flight['dateArrival']);
                            $filteredDataArray['outbound 2 flight number'][] = $flight['companyCode'] . $flight['number'];
                        }
                        elseif (
                            $flight['airportDeparture']['code'] == $flightsDetails['tripFrom'] &&
                            $flight['airportArrival']['code'] == $flightsDetails['tripTo'] &&
                            $journey['recommendationId'] == $key
                            ) {
                            $filteredDataArray['outbound 2 airport departure'][] = '-';
                            $filteredDataArray['outbound 2 airport arrival'][] = '-';
                            $filteredDataArray['outbound 2 time departure'][] = '-';
                            $filteredDataArray['outbound 2 time arrival'][] = '-';
                            $filteredDataArray['outbound 2 flight number'][] = '-';
                        }
                    }
                }
            }
        }
        return $filteredDataArray;
    }
}
