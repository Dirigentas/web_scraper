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
    public static function FormatSearchCriteria(array $searchCriteria): array
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
    public static function FormatDate(string $input): string
    {
        return date('Y-m-d H:i', strtotime($input));
    }
}
