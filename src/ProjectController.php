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
        FileDelition::deleteOldFiles();

        $emptyAssociativeArray = OutputArrayPreparer::makeOutputArray();

        $searchCriteria = JsonDataReader::readSearchCriteria();

        $formattedSearchCriteria = Formatting::formatSearchCriteria($searchCriteria);

        $response = ApiReader::makeHttpRequest($formattedSearchCriteria);

        // Iterates all searches Response one by one
        foreach ($response as $searchId => $searchData) {
            $fileName = ApiReader::writeData($searchId, $searchData);

            $decodedFlightsData = JsonDataReader::readFlightsData($fileName);

            $tickedPrices = TicketPriceScraper::extractTickedPrices($decodedFlightsData);

            $directionCombinations = FlighsCombinationHelper::countDirectionFlights($formattedSearchCriteria, $searchId, $decodedFlightsData);

            $filteredDataArray = OutboundFlightsExtracter::extractOutbound1Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $emptyAssociativeArray, $tickedPrices, $directionCombinations);

            $filteredDataArray = OutboundFlightsExtracter::extractOutbound2Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $filteredDataArray, $directionCombinations);

            $filteredDataArray = InboundFlightsExtracter::extractInbound1Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $filteredDataArray, $directionCombinations);

            $filteredDataArray = InboundFlightsExtracter::extractInbound2Flights($formattedSearchCriteria, $searchId, $decodedFlightsData, $filteredDataArray, $directionCombinations);

            $csvDataArray = OutputArrayPreparer::arrayTransposer($filteredDataArray);

            DataToCsvWriter::writeData($csvDataArray, $searchId);
        }
    }
}
