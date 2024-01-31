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
class InboundFlightsExtracter
{
    /**
     * ...
     *
     * @param
     * @return
     */
    public static function ExtractInbound1Flights(array $flightsDetails, array $jsonData, array $filteredDataArray): Array
    {
        $key = 0;
        foreach ($jsonData['body']['data']['journeys'] as $journey) {
            foreach ($journey['flights'] as $flight) {

                if ($flight['airportDeparture']['code'] == $flightsDetails['tripTo']) {
                    
                    $filteredDataArray['Taxes'][$key] += $journey['importTaxAdl'];

                    $filteredDataArray['inbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                    $filteredDataArray['inbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                    $filteredDataArray['inbound 1 time departure'][] = Formatting::formatDate($flight['dateDeparture']);
                    $filteredDataArray['inbound 1 time arrival'][] = Formatting::formatDate($flight['dateArrival']);
                    $filteredDataArray['inbound 1 flight number'][] = $flight['companyCode'] . $flight['number'];

                    $key +=1;
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
    public static function ExtractInbound2Flights(array $flightsDetails, array $jsonData, array $filteredDataArray): Array
    {     
        foreach ($jsonData['body']['data']['journeys'] as $journey) {
            foreach ($journey['flights'] as $flight) {

                if (
                    $flight['airportDeparture']['code'] != $flightsDetails['tripTo'] &&
                    $flight['airportArrival']['code'] == $flightsDetails['tripFrom']
                ) {

                    $filteredDataArray['inbound 2 airport departure'][] = $flight['airportDeparture']['code'];
                    $filteredDataArray['inbound 2 airport arrival'][] = $flight['airportArrival']['code'];
                    $filteredDataArray['inbound 2 time departure'][] = $flight['dateDeparture'];
                    $filteredDataArray['inbound 2 time arrival'][] = $flight['dateArrival'];
                    $filteredDataArray['inbound 2 flight number'][] = $flight['companyCode'] . $flight['number'];

                } elseif ($flight['airportDeparture']['code'] == $flightsDetails['tripTo']) {
                    $filteredDataArray['inbound 2 airport departure'][] = '-';
                    $filteredDataArray['inbound 2 airport arrival'][] = '-';
                    $filteredDataArray['inbound 2 time departure'][] = '-';
                    $filteredDataArray['inbound 2 time arrival'][] = '-';
                    $filteredDataArray['inbound 2 flight number'][] = '-';
                }
            }
        } 
        return $filteredDataArray;
    }               
}
