<?php

/**
 * File purpose is to extract outbound  and  inbound  flights data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

use Aras\WebScraper\Formatting;

/**
 * Class ...
 */
class InboundFlightsExtracter
{
    /**
     * ...
     *
     * @param
     * @return
     */
    public static function ExtractInbound1Flights(array $flightsDetails, array $jsonData, array $filteredDataArray, array $directionCombinations): Array
    {
        $taxElementId = 0;
        foreach ($directionCombinations as $key => $recommendationId) {
            $outboundCombinationsCountSingleId = count($recommendationId['out']);
            foreach (range(1, $outboundCombinationsCountSingleId) as $number) {
                foreach ($jsonData['body']['data']['journeys'] as $journey) {
                    foreach ($journey['flights'] as $flight) {
        
                        if (
                            $flight['airportDeparture']['code'] == $flightsDetails['tripTo'] &&
                            $journey['recommendationId'] == $key
                        ) {                            
                            $filteredDataArray['Taxes'][$taxElementId] += $journey['importTaxAdl'];
        
                            $filteredDataArray['inbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['inbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['inbound 1 time departure'][] = Formatting::formatDate($flight['dateDeparture']);
                            $filteredDataArray['inbound 1 time arrival'][] = Formatting::formatDate($flight['dateArrival']);
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
     * ...
     *
     * @param
     * @return
     */
    public static function ExtractInbound2Flights(array $flightsDetails, array $jsonData, array $filteredDataArray, array $directionCombinations): Array
    {     
        foreach ($directionCombinations as $key => $recommendationId) {
            $outboundCombinationsCountSingleId = count($recommendationId['out']);
            foreach (range(1, $outboundCombinationsCountSingleId) as $number) {
                foreach ($jsonData['body']['data']['journeys'] as $journey) {
                    foreach ($journey['flights'] as $flight) {
        
                        if (
                            $flight['airportDeparture']['code'] != $flightsDetails['tripTo'] &&
                            $flight['airportArrival']['code'] == $flightsDetails['tripFrom'] &&
                            $journey['recommendationId'] == $key
                        ) {                                  
                            $filteredDataArray['inbound 2 airport departure'][] = $flight['airportDeparture']['code'];
                            $filteredDataArray['inbound 2 airport arrival'][] = $flight['airportArrival']['code'];
                            $filteredDataArray['inbound 2 time departure'][] = Formatting::formatDate($flight['dateDeparture']);
                            $filteredDataArray['inbound 2 time arrival'][] = Formatting::formatDate($flight['dateArrival']);
                            $filteredDataArray['inbound 2 flight number'][] = $flight['companyCode'] . $flight['number'];
                        }
                        elseif (
                            $flight['airportDeparture']['code'] == $flightsDetails['tripTo'] &&
                            $flight['airportArrival']['code'] == $flightsDetails['tripFrom'] &&
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
