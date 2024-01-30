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
    public static function OutboundFlights(array $parsedData)
    {
        $OutboundFlights = [];

        foreach ($parsedData['body']['data']['journeys'] as $journey) {
            $OutboundFlights[] = $journey['flights'][0]['airportDeparture']['code'];
        }

        print_r($OutboundFlights);
    }
}
