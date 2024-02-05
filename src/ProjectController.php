<?php

/**
 * File purpose is to call all required methods.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

use Aras\WebScraper\Formatting;
use Aras\WebScraper\FlightDataRequester;
use Aras\WebScraper\ApiReader;
use Aras\WebScraper\JsonDataReader;
use Aras\WebScraper\OutputArrayPreparer;
use Aras\WebScraper\data_extraction\TicketPriceScraper;
use Aras\WebScraper\data_extraction\FlighsCombinationHelper;
use Aras\WebScraper\data_extraction\OutboundFlightsExtracter;
use Aras\WebScraper\data_extraction\InboundFlightsExtracter;
use Aras\WebScraper\DataToCsvWriter;

/**
 * Class ProjectController controls all paths of the solution.
 */
final class ProjectController
{
    /**
     * This method executes all needed classes.
     *
     * @return void
     */
    public static function executeAllClasses(): void
    {
        $emptyAssociativeArray = OutputArrayPreparer::MakeOutputArray();

        $searchCriteria = JsonDataReader::ReadSearchCriteria();

        $formattedSearchCriteria = Formatting::formatSearchCriteria($searchCriteria);

        $response = ApiReader::MakeHttpRequest($formattedSearchCriteria);

        foreach ($response as $searchId => $searchData) {
            $fileName = ApiReader::WriteData($searchId, $searchData);
            
            $decodedFlightsData = JsonDataReader::ReadFlightsData($fileName);
            // $decodedFlightsData = JsonDataReader::ReadFlightsData('multiple_search_parameter_sets.json');
            
            $tickedPrices = TicketPriceScraper::ExtractTickedPrices($decodedFlightsData);
            
            $directionCombinations = FlighsCombinationHelper::CountDirectionFlights($formattedSearchCriteria, $searchId, $decodedFlightsData);
            
            $filteredDataArray = OutboundFlightsExtracter::ExtractOutbound1Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $emptyAssociativeArray, $tickedPrices, $directionCombinations);
            
            $filteredDataArray = OutboundFlightsExtracter::ExtractOutbound2Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $filteredDataArray, $tickedPrices, $directionCombinations);
            
            $filteredDataArray = InboundFlightsExtracter::ExtractInbound1Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $filteredDataArray, $directionCombinations);
    
            $filteredDataArray = InboundFlightsExtracter::ExtractInbound2Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $filteredDataArray, $directionCombinations);
            
            $csvDataArray = OutputArrayPreparer::ArrayTransposer($filteredDataArray);
            
            DataToCsvWriter::WriteData($csvDataArray, $searchId);
            
        }      



    }
}
