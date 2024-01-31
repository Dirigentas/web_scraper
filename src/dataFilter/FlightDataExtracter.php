<?php

/**
 * File purpose is to extract outbound  and  inbound  flights data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\dataFilter;

/**
 * Class ...
 */
class FlightDataExtracter
{
    /**
     * ...
     *
     * @param array[] ...
     *
     * @return array[] Array of transactions with the S package discount applied.
     */
    public static function OutboundFlights(array $parsedData, array $flightsDetails)
    {
        $outputData = [
            "Price"=>[],
            "Taxes"=>[],
            "outbound 1 airport departure"=>[],
            "outbound 1 airport arrival"=>[],
            "outbound 1 time departure"=>[],
            "outbound 1 time arrival"=>[],
            "outbound 1 flight number"=>[],
            "outbound 2 airport departure"=>[],
            "outbound 2 airport arrival"=>[],
            "outbound 2 time departure"=>[],
            "outbound 2 time arrival"=>[],
            "outbound 2 flight number"=>[],
            "inbound 1 airport departure"=>[],
            "inbound 1 airport arrival"=>[],
            "inbound 1 time departure"=>[],
            "inbound 1 time arrival"=>[],
            "inbound 1 flight number"=>[],
            "inbound 2 airport departure"=>[],
            "inbound 2 airport arrival"=>[],
            "inbound 2 time departure"=>[],
            "inbound 2 time arrival"=>[],
            "inbound 2 flight number"=>[]
        ];

        $prices = [];
        foreach ($parsedData['body']['data']['totalAvailabilities'] as $availablePrice) {
            $prices[$availablePrice['recommendationId']] = $availablePrice['total'];
        }

        foreach ($parsedData['body']['data']['journeys'] as $journey) {
            foreach ($journey['flights'] as $flight) {

                if ($flight['airportDeparture']['code'] == $flightsDetails['tripFrom']) {

                    $outputData['Price'][] = $prices[$journey['recommendationId']];
                    
                    $outputData['Taxes'][] = $journey['importTaxAdl'];

                    $outputData['outbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                    $outputData['outbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                    $outputData['outbound 1 time departure'][] = date('Y-m-d H:i', strtotime($flight['dateDeparture']));
                    $outputData['outbound 1 time arrival'][] = date('Y-m-d H:i', strtotime($flight['dateArrival']));
                    $outputData['outbound 1 flight number'][] = $flight['companyCode'] . $flight['number'];
                }

                if ($flight['airportDeparture']['code'] == $flightsDetails['tripTo']) {

                    $outputData['Taxes'][count($outputData['Taxes']) - 1] += $journey['importTaxAdl'];

                    $outputData['inbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                    $outputData['inbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                    $outputData['inbound 1 time departure'][] = date('Y-m-d H:i', strtotime($flight['dateDeparture']));
                    $outputData['inbound 1 time arrival'][] = date('Y-m-d H:i', strtotime($flight['dateArrival']));
                    $outputData['inbound 1 flight number'][] = $flight['companyCode'] . $flight['number'];
                }

                if (
                    $flight['airportDeparture']['code'] != $flightsDetails['tripFrom'] &&
                    $flight['airportArrival']['code'] == $flightsDetails['tripTo']
                ) {

                    $outputData['outbound 2 airport departure'][] = $flight['airportDeparture']['code'];
                    $outputData['outbound 2 airport arrival'][] = $flight['airportArrival']['code'];
                    $outputData['outbound 2 time departure'][] = $flight['dateDeparture'];
                    $outputData['outbound 2 time arrival'][] = $flight['dateArrival'];
                    $outputData['outbound 2 flight number'][] = $flight['companyCode'] . $flight['number'];

                } elseif ($flight['airportDeparture']['code'] == $flightsDetails['tripFrom']) {
                    $outputData['outbound 2 airport departure'][] = '-';
                    $outputData['outbound 2 airport arrival'][] = '-';
                    $outputData['outbound 2 time departure'][] = '-';
                    $outputData['outbound 2 time arrival'][] = '-';
                    $outputData['outbound 2 flight number'][] = '-';
                } {
                }

                if (
                    $flight['airportDeparture']['code'] != $flightsDetails['tripTo'] &&
                    $flight['airportArrival']['code'] == $flightsDetails['tripFrom']
                ) {

                    $outputData['inbound 2 airport departure'][] = $flight['airportDeparture']['code'];
                    $outputData['inbound 2 airport arrival'][] = $flight['airportArrival']['code'];
                    $outputData['inbound 2 time departure'][] = $flight['dateDeparture'];
                    $outputData['inbound 2 time arrival'][] = $flight['dateArrival'];
                    $outputData['inbound 2 flight number'][] = $flight['companyCode'] . $flight['number'];

                } elseif ($flight['airportDeparture']['code'] == $flightsDetails['tripTo']) {
                    $outputData['inbound 2 airport departure'][] = '-';
                    $outputData['inbound 2 airport arrival'][] = '-';
                    $outputData['inbound 2 time departure'][] = '-';
                    $outputData['inbound 2 time arrival'][] = '-';
                    $outputData['inbound 2 flight number'][] = '-';
                } {
                }
            }
        }

        $csvData = [];

        foreach ($outputData as $row => $columns) {
            foreach ($columns as $column => $value) {
                $csvData[$column][$row] = $value;
            }
        }

        $file = fopen('./public/' . $flightsDetails['tripFrom'] . '-' . $flightsDetails['tripTo']
        . '_(' . $flightsDetails['departDate'] . ')-(' . $flightsDetails['returnDate'] . ').csv', 'w');

        fputcsv($file, [
            "Price",
            "Taxes",
            "outbound 1 airport departure",
            "outbound 1 airport arrival",
            "outbound 1 time departure",
            "outbound 1 time arrival",
            "outbound 1 flight number",
            "outbound 2 airport departure",
            "outbound 2 airport arrival",
            "outbound 2 time departure",
            "outbound 2 time arrival",
            "outbound 2 flight number",
            "inbound 1 airport departure",
            "inbound 1 airport arrival",
            "inbound 1 time departure",
            "inbound 1 time arrival",
            "inbound 1 flight number",
            "inbound 2 airport departure",
            "inbound 2 airport arrival",
            "inbound 2 time departure",
            "inbound 2 time arrival",
            "inbound 2 flight number"
        ]);

        foreach ($csvData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);


        // print_r($outputData);
        // print_r($csvData);
    }
}
