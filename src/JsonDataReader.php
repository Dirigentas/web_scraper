<?php

/**
 * Represents a class for reading data from a JSON file.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class JsonDataReader
 * Represents a class for reading data from a JSON file.
 */
final class JsonDataReader
{   
    /**
     * Reads and decodes JSON data from a file.
     *
     * @param string $fileName The name of the JSON file to read data from.
     * @return array[]|null Returns the decoded JSON data as an associative array on success, or null on failure.
     */ 
    public static function ReadData(string $fileName): ?array
    {
        try {
            $json = file_get_contents('./public/' . $fileName);
        
            if ($json === false) {
                throw new \Exception("When reading file");
            }
            $parsedData = json_decode($json, true);
        
            if ($parsedData === null) {
                throw new \Exception("When decoding JSON");
            }
            echo "Read and decode Json file succesfully.". PHP_EOL;
        
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage(). PHP_EOL;
        }
        return $parsedData;
    }
}
