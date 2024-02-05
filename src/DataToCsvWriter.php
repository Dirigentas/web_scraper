<?php

/**
 * Represents a class for writing data to a CSV file.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class DataToCsvWriter
 * Represents a class for writing data to a CSV file.
 */
final class DataToCsvWriter
{    
    /**
     * This method writes the provided data to a CSV file with the specified filename format.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data.
     * @param array $csvDataArray An array containing the data to be written to the CSV file.
     * @return void
     */
    public static function WriteData(array $csvDataArray, string $searchId): void
    {
        if ($searchId == 'search_1') {
            $csvFileName = fopen('./public/search_results.csv', 'w');

            fputcsv($csvFileName, [
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
                "inbound 2 flight number",
                "Cheapest"
            ]);
        }
        else {
            $csvFileName = fopen('./public/search_results.csv', 'a');
        }

        foreach ($csvDataArray as $row) {
            fputcsv($csvFileName, $row);
        }

        fclose($csvFileName);
    }
}
