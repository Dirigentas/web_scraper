<?php

/**
 * Class purpose is to parse data.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class ....
 */
final class DataParser
{    
    public static function ParseData(string $fileName)
    {
        try {
            // Read JSON data from file
            $json = file_get_contents('./public/' . $fileName);
        
            if ($json === false) {
                throw new \Exception("When reading file");
            }
        
            // Decode JSON data
            $parsedData = json_decode($json, true);
        
            if ($parsedData === null) {
                throw new \Exception("When decoding JSON");
            }
        
            // Process the parsed data
            echo "Read and decode Json file succesfully.". PHP_EOL;
        
        } catch (\Exception $e) {
            // Handle exceptions
            echo "An error occurred: " . $e->getMessage(). PHP_EOL;
        }
        return $parsedData;
    }
}
