<?php

/**
 * Class for deleting old files.
 */

declare(strict_types=1);

namespace Aras\WebScraper\utilities;

/**
 * Provides functionality to delete old files.
 */
class FileDelition
{
    /**
     * Deletes old files from the public directory.
     *
     * Loops through a range of search numbers and deletes corresponding files if they exist.
     *
     * @return void
     */
    public static function deleteOldFiles(): void
    {
        foreach (range(1, 11) as $key => $searcg) {
            $fileToDelete = './public/search_' . $key . '.json';

            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }
    }
}
