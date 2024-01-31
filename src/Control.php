<?php

/**
 * File purpose is to call all required methods.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

use Aras\WebScraper\FlightsDetails;
use Aras\WebScraper\ApiReader;
use Aras\WebScraper\DataParser;
use Aras\WebScraper\dataFilter\FlightDataExtracter;

/**
 * Class Control controls all pats of the solution.
 */
final class Control
{
    /**
     * This method executes all needed classes.
     *
     * @return void
     */
    public function executeAllClasses(): void
    {
        $flightsDetails = FlightsDetails::AirportAndDatesChooser();

        $response = ApiReader::MakeHttpRequest($flightsDetails);

        $fetchedData = ApiReader::FetchData($response, $flightsDetails);

        $parsedData = DataParser::ParseData($fetchedData);

        FlightDataExtracter::OutboundFlights($parsedData, $flightsDetails);
    }
}
