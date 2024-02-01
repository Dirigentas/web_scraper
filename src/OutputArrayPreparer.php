<?php

/**
 * File purpose is to create and prepare array for future filtered output.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class ...
 */
class OutputArrayPreparer
{
    /**
     * ...
     *
     * @return array[] Array for future filtered output.
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
     * Transposes array in preparation for writing to CSV file.
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