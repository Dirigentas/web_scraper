<?php

/**
 * File purpose is to format data appropriately.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class Formatting is responsible for formatting given data.
 */
class Formatting
{
    /**
     *
     */
    public static function formatSearchCriteria(array $searchCriteria): array
    {
        $searchCriteria['departDate'] = $searchCriteria['departDate']['year'] .
        '-' . $searchCriteria['departDate']['month'] . '-' . $searchCriteria['departDate']['day'];

        $searchCriteria['returnDate'] = $searchCriteria['returnDate']['year'] .
        '-' . $searchCriteria['returnDate']['month'] . '-' . $searchCriteria['returnDate']['day'];

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
