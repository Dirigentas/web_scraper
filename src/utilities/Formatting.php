<?php

/**
 * File purpose is to format data appropriately.
 */

declare(strict_types=1);

namespace Aras\WebScraper\utilities;

/**
 * Class Formatting is responsible for formatting given data.
 */
class Formatting
{
    /**
     * Formats the search criteria array to ensure date values are in the correct format.
     * @param array $searchCriteria The search criteria array containing date values to be formatted.
     *
     * @return array The formatted search criteria array.
      */
    public static function formatSearchCriteria(array $searchCriteria): array
    {
        foreach ($searchCriteria as &$singleSearch) {
            $singleSearch['departDate'] = $singleSearch['departDate']['year'] .
            '-' . $singleSearch['departDate']['month'] . '-' . $singleSearch['departDate']['day'];

            $singleSearch['returnDate'] = $singleSearch['returnDate']['year'] .
            '-' . $singleSearch['returnDate']['month'] . '-' . $singleSearch['returnDate']['day'];
        }
        return $searchCriteria;
    }


    /**
     * Formats dates.
     *
     * @param string $input String with base date format.
     *
     * @return string String of formatted date.
     */
    public static function formatDate(string $input): string
    {
        return date('Y-m-d H:i', strtotime($input));
    }
}
