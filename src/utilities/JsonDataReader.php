<?php

/**
 * Represents a class for reading data from a JSON files.
 */

declare(strict_types=1);

namespace Aras\WebScraper\utilities;

use Aras\WebScraper\utilities\Validations;

/**
 * Class JsonDataReader
 * Represents a class for reading data from a JSON files.
 */
final class JsonDataReader
{   
    /**
     * Reads and decodes JSON search parameters from a file.
     *
     * @return array[]|null Returns the decoded JSON data as an associative array on success, or null on failure.
     */ 
    public static function ReadSearchCriteria(): ?array
    {
        $json = file_get_contents('./public/search_criteria.json');

        $parsedSearchCriteria = json_decode($json, true);

        Validations::SearchCriteriaValidation($parsedSearchCriteria);
        
        return $parsedSearchCriteria;
    }
    
    /**
     * Reads and decodes JSON data from a file.
     *
     * @param string $fileName The name of the JSON file to read data from.
     * @return array[]|null Returns the decoded JSON data as an associative array on success, or null on failure.
     */ 
    public static function ReadFlightsData(string $fileName): ?array
    {
        try {
            $json = file_get_contents('./public/' . $fileName);
        
            if ($json === false) {
                throw new \Exception("When reading file");
            }
            $decodedFlightsData = json_decode($json, true);
        
            if ($decodedFlightsData === null) {
                throw new \Exception("When decoding JSON");
            }
            echo "Read and decode Json file succesfully.". PHP_EOL;
        
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage(). PHP_EOL;
        }
        return $decodedFlightsData;
    }
}
