<?php

/**
 * Represents a class for extracting outbound flights data based on provided flight details from JSON data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

use Aras\WebScraper\Formatting;
use Aras\WebScraper\data_extraction\TwoConnectionsSkipper;
use Aras\WebScraper\data_extraction\TicketPriceScraper;

/**
 * Class OutboundFlightsExtracter
 * Represents a class for extracting outbound flights data based on provided flight details from JSON data.
 */
class OutboundFlightsExtracter
{
    /**
     * This method extracts data for the first outbound flights based on JSON data.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data.
     * @param array $jsonData The JSON data containing flight details.
     * @param array $filteredDataArray An array prepared to be filled with filtered data.
     * @param array $tickedPrices An array containing ticket prices data.
     * @param array $directionCombinations An array containing direction combinations data.
     * @return array The updated filtered data array with outbound 1 flight data.
     */
    public static function ExtractOutbound1Flights(array $formattedSearchCriteria, string $searchId, array $jsonData, array $filteredDataArray, array $tickedPrices, array $directionCombinations): Array
    {
        foreach ($directionCombinations as $key => $flightNo) {
            $inboundCombinationsCountSingleId = count($flightNo['in']);
            foreach ($jsonData['body']['data']['journeys'] as $journey) {

                if (TwoConnectionsSkipper::SkipTwoConnections($journey)) {
                    continue;
                }

                foreach ($journey['flights'] as $flight) {
                    foreach (range(1, $inboundCombinationsCountSingleId) as $number) {
                        if (
                            $flight['airportDeparture']['code'] == $formattedSearchCriteria[$searchId]['tripFrom'] &&
                            $journey['recommendationId'] == $key
                        ) {
        
                            $filteredDataArray['Price'][] = $tickedPrices[$journey['recommendationId']];
                            
                            $filteredDataArray['Taxes'][] = $journey['importTaxAdl'];
        
                            $filteredDataArray['outbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['outbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['outbound 1 time departure'][] = Formatting::FormatDate($flight['dateDeparture']);
                            $filteredDataArray['outbound 1 time arrival'][] = Formatting::FormatDate($flight['dateArrival']);
                            $filteredDataArray['outbound 1 flight number'][] = $flight['companyCode'] . $flight['number'];

                            if ($journey['recommendationId'] == TicketPriceScraper::FindCheapestRecommendation($jsonData)) {
                                $filteredDataArray['Cheapest'][] = 'Yes';
                            } else {
                                $filteredDataArray['Cheapest'][] = 'No';
                            }
                        }
                    }
                }
            }
        }
        return $filteredDataArray;
    }

    /**
     * This method extracts data for the second outbound flights based on JSON data.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data
     * @param array $jsonData The JSON data containing flight details.
     * @param array $filteredDataArray An array prepared to be filled with filtered data.
     * @param array $tickedPrices An array containing ticket prices data.
     * @param array $directionCombinations An array containing direction combinations data.
     * @return array The updated filtered data array with outbound 2 flight data.
     */
    public static function ExtractOutbound2Flights(array $formattedSearchCriteria, string $searchId, array $jsonData, array $filteredDataArray, array $tickedPrices, array $directionCombinations): Array
    {
        foreach ($directionCombinations as $key => $flightNo) {
            $inboundCombinationsCountSingleId = count($flightNo['in']);
            foreach ($jsonData['body']['data']['journeys'] as $journey) {

                if (TwoConnectionsSkipper::SkipTwoConnections($journey)) {
                    continue;
                }

                foreach ($journey['flights'] as $flight) {
                    foreach (range(1, $inboundCombinationsCountSingleId) as $number) {

                        if (
                            $flight['airportDeparture']['code'] != $formattedSearchCriteria[$searchId]['tripFrom'] &&
                            $flight['airportArrival']['code'] == $formattedSearchCriteria[$searchId]['tripTo'] &&
                            $journey['recommendationId'] == $key
                        ) {        
                            $filteredDataArray['outbound 2 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['outbound 2 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['outbound 2 time departure'][] = Formatting::FormatDate($flight['dateDeparture']);
                            $filteredDataArray['outbound 2 time arrival'][] = Formatting::FormatDate($flight['dateArrival']);
                            $filteredDataArray['outbound 2 flight number'][] = $flight['companyCode'] . $flight['number'];
                        }
                        elseif (
                            $flight['airportDeparture']['code'] == $formattedSearchCriteria[$searchId]['tripFrom'] &&
                            $flight['airportArrival']['code'] == $formattedSearchCriteria[$searchId]['tripTo'] &&
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
