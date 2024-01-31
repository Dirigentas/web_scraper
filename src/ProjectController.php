<?php

/**
 * File purpose is to call all required methods.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

use Aras\WebScraper\FlightsDetails;
use Aras\WebScraper\ApiReader;
use Aras\WebScraper\DataParser;
use Aras\WebScraper\dataFilter\TicketPriceScraper;
use Aras\WebScraper\dataFilter\OutboundFlightsExtracter;
use Aras\WebScraper\dataFilter\InboundFlightsExtracter;
use Aras\WebScraper\DataToCsvWriter;

/**
 * Class Control controls all pats of the solution.
 */
final class ProjectController
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

        $jsonData = DataToJsonWriter::WriteData($fetchedData);

        $emptyFilteredDataArray = OutputArrayPreparer::MakeOutputArray();

        $tickedPrices = TicketPriceScraper::ExtractTickedPrices($jsonData);

        $filteredDataArray = OutboundFlightsExtracter::ExtractOutbound1Flights($flightsDetails, $jsonData, $emptyFilteredDataArray, $tickedPrices);
        
        $filteredDataArray = OutboundFlightsExtracter::ExtractOutbound2Flights($flightsDetails, $jsonData, $filteredDataArray, $tickedPrices);

        $filteredDataArray = InboundFlightsExtracter::ExtractInbound1Flights($flightsDetails, $jsonData, $filteredDataArray);

        $filteredDataArray = InboundFlightsExtracter::ExtractInbound2Flights($flightsDetails, $jsonData, $filteredDataArray);

        $csvDataArray = OutputArrayPreparer::ArrayTransposer($filteredDataArray);

        DataToCsvWriter::WriteData($flightsDetails, $csvDataArray);
    }
}
