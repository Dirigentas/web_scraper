<?php

/**
 * File purpose is to extract outbound  and  inbound  flight data.
 */

declare(strict_types=1);

namespace Aras\WebScraper\dataFilter;

/**
 * Class LowestPriceFinder contains methods for calculating discount on shipments.
 */
class FlightDataExtracter
{
    /**
     * Applies a discount to the chosen package size.
     *
     * @param array[] $output   The array of transactions to be processed.
     * @param array[] $couriersDetails Contains the courier and package size information.
     *
     * @return array[] Array of transactions with the S package discount applied.
     */
    public static function OutboundFlights(array $parsedData, array $flightDetails)
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

        foreach ($parsedData['body']['data']['journeys'] as $journey) {
            $flight = $journey['flights'][0];

            if ($flight['airportDeparture']['code'] == $flightDetails['tripFrom']) {

                $outputData['outbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                $outputData['outbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                $outputData['outbound 1 time departure'][] = $flight['dateDeparture'];
                $outputData['outbound 1 time arrival'][] = $flight['dateArrival'];
                $outputData['outbound 1 flight number'][] = $flight['number'];
            }

            if ($flight['airportDeparture']['code'] == $flightDetails['tripTo']) {

                $outputData['inbound 1 airport departure'][] = $flight['airportDeparture']['code'];
                $outputData['inbound 1 airport arrival'][] = $flight['airportArrival']['code'];
                $outputData['inbound 1 time departure'][] = $flight['dateDeparture'];
                $outputData['inbound 1 time arrival'][] = $flight['dateArrival'];
                $outputData['inbound 1 flight number'][] = $flight['number'];
            } 
        }

        $csvData = [];

        foreach ($outputData as $row => $columns) {
            foreach ($columns as $column => $value) {
                $csvData[$column][$row] = $value;
            }
        }

        $file = fopen('./public/flightsData.csv', 'w');

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
