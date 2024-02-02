<?php

/**
 * Represents a class for preparing arrays for future data processing.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class OutputArrayPreparer
 * Represents a class for preparing arrays for future data processing.
 */
class OutputArrayPreparer
{
    /**
     * Creates an empty array structure for future data.
     *
     * @return array An array structure with empty arrays for storing data, organized by data categories.
     */
    public static function MakeOutputArray(): Array
    {
        $emptyFilteredDataArray = [
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

        return $emptyFilteredDataArray;
    }

    /**
     * Transposes array in preparation for to writing it to a CSV file.
     * 
     * @param array $filteredDataArray Array of filtered data.
     * @return array $csvDataArray Transposed filtered data array.
     */
    public static function ArrayTransposer(array $filteredDataArray): Array
    {
        $csvDataArray = [];

        foreach ($filteredDataArray as $row => $columns) {
            foreach ($columns as $column => $value) {
                $csvDataArray[$column][$row] = $value;
            }
        }
        return $csvDataArray;
    }
}
