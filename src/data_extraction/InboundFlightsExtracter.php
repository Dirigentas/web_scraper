<?php

/**
 * Represents a class for extracting inbound flights data based on provided flight details from JSON data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

use Aras\WebScraper\utilities\Formatting;
use Aras\WebScraper\data_extraction\TwoConnectionsSkipper;

/**
 * Class InboundFlightsExtracter
 * Represents a class for extracting inbound flights data based on provided flight details from JSON data.
 */
class InboundFlightsExtracter
{
    /**
     * This method extracts data for the first inbound flights based on JSON data.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data.
     * @param string $searchId String containing ID of the current search.
     * @param array $jsonData The JSON data containing flight details.
     * @param array $filteredDataArray An array prepared to be filled with filtered data.
     * @param array $directionCombinations An array containing direction combinations data.
     * @return array The updated filtered data array with inbound 1 flight data.
     */
    public static function ExtractInbound1Flights(array $formattedSearchCriteria, string $searchId, array $jsonData, array $filteredDataArray, array $directionCombinations): Array
    {
        $taxElementId = 0;
        foreach ($directionCombinations as $key => $flightNo) {
            $outboundCombinationsCountSingleId = count($flightNo['out']);
            foreach (range(1, $outboundCombinationsCountSingleId) as $number) {
                foreach ($jsonData['body']['data']['journeys'] as $journey) {

                    if (TwoConnectionsSkipper::SkipTwoConnections($journey)) {
                        continue;
                    }

                    foreach ($journey['flights'] as $flight) {
        
                        if (
                            $flight['airportDeparture']['code'] == $formattedSearchCriteria[$searchId]['tripTo'] &&
                            $journey['recommendationId'] == $key
                        ) {                            
                            $filteredDataArray['Taxes'][$taxElementId] += $journey['importTaxAdl'];
        
                            $filteredDataArray['inbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['inbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['inbound 1 time departure'][] = Formatting::FormatDate($flight['dateDeparture']);
                            $filteredDataArray['inbound 1 time arrival'][] = Formatting::FormatDate($flight['dateArrival']);
                            $filteredDataArray['inbound 1 flight number'][] = $flight['companyCode'] . $flight['number'];

                            $taxElementId +=1;
                        }
                    }
                }
            }
        }
        return $filteredDataArray;
    }
    
    /**
     * This method extracts data for the second inbound flights based on JSON data.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data.
     * @param string $searchId String containing ID of the current search.
     * @param array $jsonData The JSON data containing flight details.
     * @param array $filteredDataArray An array prepared to be filled with filtered data.
     * @param array $directionCombinations An array containing direction combinations data.
     * @return array The updated filtered data array with inbound 2 flight data.
     */
    public static function ExtractInbound2Flights(array $formattedSearchCriteria, string $searchId, array $jsonData, array $filteredDataArray, array $directionCombinations): Array
    {     
        foreach ($directionCombinations as $key => $flightNo) {
            $outboundCombinationsCountSingleId = count($flightNo['out']);
            foreach (range(1, $outboundCombinationsCountSingleId) as $number) {
                foreach ($jsonData['body']['data']['journeys'] as $journey) {

                    if (TwoConnectionsSkipper::SkipTwoConnections($journey)) {
                        continue;
                    }

                    foreach ($journey['flights'] as $flight) {
        
                        if (
                            $flight['airportDeparture']['code'] != $formattedSearchCriteria[$searchId]['tripTo'] &&
                            $flight['airportArrival']['code'] == $formattedSearchCriteria[$searchId]['tripFrom'] &&
                            $journey['recommendationId'] == $key
                        ) {                                  
                            $filteredDataArray['inbound 2 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['inbound 2 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['inbound 2 time departure'][] = Formatting::FormatDate($flight['dateDeparture']);
                            $filteredDataArray['inbound 2 time arrival'][] = Formatting::FormatDate($flight['dateArrival']);
                            $filteredDataArray['inbound 2 flight number'][] = $flight['companyCode'] . $flight['number'];
                        }
                        elseif (
                            $flight['airportDeparture']['code'] == $formattedSearchCriteria[$searchId]['tripTo'] &&
                            $flight['airportArrival']['code'] == $formattedSearchCriteria[$searchId]['tripFrom'] &&
                            $journey['recommendationId'] == $key
                        ) {
                            $filteredDataArray['inbound 2 airport departure'][] = '-';
                            $filteredDataArray['inbound 2 airport arrival'][] = '-';
                            $filteredDataArray['inbound 2 time departure'][] = '-';
                            $filteredDataArray['inbound 2 time arrival'][] = '-';
                            $filteredDataArray['inbound 2 flight number'][] = '-';
                        }
                    }
                }
            }
        }
        return $filteredDataArray;
    }               
}
