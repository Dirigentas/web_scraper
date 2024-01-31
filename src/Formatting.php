<?php

/**
 * File purpose is to format data appropriately.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class Formatting is responsible for formatting given dates.
 */
class Formatting
{
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
