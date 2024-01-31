<?php

/**
 * Class purpose is to write data to CSV file.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class ....
 */
final class DataToCsvWriter
{    
    public static function WriteData(array $flightsDetails, array $csvDataArray): void
    {
        $csvFileName = fopen('./public/' . $flightsDetails['tripFrom'] . '-' . $flightsDetails['tripTo']
        . '_(' . $flightsDetails['departDate'] . ')-(' . $flightsDetails['returnDate'] . ').csv', 'w');

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
            "inbound 2 flight number"
        ]);

        foreach ($csvDataArray as $row) {
            fputcsv($csvFileName, $row);
        }

        fclose($csvFileName);
    }
}
