<?php

/**
 * File purpose is to call all required methods.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

use Aras\WebScraper\FlightsDetails;
use Aras\WebScraper\ApiReader;
use Aras\WebScraper\JsonDataReader;
use Aras\WebScraper\OutputArrayPreparer;
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

        // $response = ApiReader::MakeHttpRequest($flightsDetails);

        // $fileName = ApiReader::WriteData($response, $flightsDetails);

        // $jsonData = JsonDataReader::ReadData($fileName);
        $jsonData = JsonDataReader::ReadData('MAD-FUE_(2024-02-09)-(2024-02-16).json');
        // $jsonData = JsonDataReader::ReadData('MAD-AUH_(2024-02-09)-(2024-02-16).json');

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
