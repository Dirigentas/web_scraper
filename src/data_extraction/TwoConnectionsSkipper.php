<?php

/**
 *
 * This class provides functionality to determine if a journey should skip two connections.
 */

declare(strict_types=1);

namespace Aras\WebScraper\data_extraction;

/**
 * Class TwoConnectionsSkipper
 *
 * This class provides functionality to determine if a journey should skip two connections.
 */
class TwoConnectionsSkipper
{
    /**
     * Check if a journey has more than two connections.
     *
     * @param array $journey An array representing the journey.
     *
     * @return bool Returns true if the journey has more than two connections, otherwise returns false.
     */
    public static function skipTwoConnections(array $journey): bool
    {
        if (count($journey['flights']) > 2) {
            return true;
        }
        return false;
    }
}
