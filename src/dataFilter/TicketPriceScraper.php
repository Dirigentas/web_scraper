<?php

/**
 * File purpose is to extract ticked prices.
 */

declare(strict_types=1);

namespace Aras\WebScraper\dataFilter;

/**
 * Class ...
 */
class TicketPriceScraper
{
    /**
     * ...
     *
     * @param
     * @return
     */
    public static function ExtractTickedPrices(array $jsonData): Array
    {
        $prices = [];
        foreach ($jsonData['body']['data']['totalAvailabilities'] as $availablePrice) {
            $prices[$availablePrice['recommendationId']] = $availablePrice['total'];
        }

        return $prices;
    }
}
