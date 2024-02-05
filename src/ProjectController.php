<?php

/**
 * File purpose is to call all required methods.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

use Aras\WebScraper\utilities\Formatting;
use Aras\WebScraper\utilities\ApiReader;
use Aras\WebScraper\utilities\JsonDataReader;
use Aras\WebScraper\utilities\OutputArrayPreparer;
use Aras\WebScraper\data_extraction\TicketPriceScraper;
use Aras\WebScraper\data_extraction\FlighsCombinationHelper;
use Aras\WebScraper\data_extraction\OutboundFlightsExtracter;
use Aras\WebScraper\data_extraction\InboundFlightsExtracter;
use Aras\WebScraper\utilities\DataToCsvWriter;
use Aras\WebScraper\utilities\FileDelition;

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
        FileDelition::DeleteOldFiles();

        $emptyAssociativeArray = OutputArrayPreparer::MakeOutputArray();

        $searchCriteria = JsonDataReader::ReadSearchCriteria();

        $formattedSearchCriteria = Formatting::FormatSearchCriteria($searchCriteria);
        
        $response = ApiReader::MakeHttpRequest($formattedSearchCriteria);

        foreach ($response as $searchId => $searchData) {
            $fileName = ApiReader::WriteData($searchId, $searchData);
            
            $decodedFlightsData = JsonDataReader::ReadFlightsData($fileName);
            
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
