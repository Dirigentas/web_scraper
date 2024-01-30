<?php

/**
 * Class purpose is to make adjustments to $flightsDetails
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class FlightsDetails modifies flights details.
 */
final class FlightsDetails
{
    /**
     * @var array $airportsFrom An array containing the settings for flights details.
     * @var array $airportsTo An array containing the settings for flights details.
    */
    private $airportsFrom = ['MAD', 'JFK', 'CPH'];
    private $airportsTo = ['AUH', 'FUE', 'MAD'];
    
    /**
     * Sends HTTP request to API and gets a response.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
    public static function MakeHttpRequest(): bool|string
    {   
        // API URL
        $url = 'http://homeworktask.infare.lt/search.php?from=MAD&to=FUE&depart=2024-02-09&return=2024-02-16';

        // Fetch API data
        $response  = file_get_contents($url);

        try {
            // Fetch API data
            $response  = file_get_contents($url);
        
            if ($response === false) {
                throw new \Exception("While fetching API");
            }
        
            // Process the parsed data
            echo "Fetched API data succesfully.". PHP_EOL;
        
        } catch (\Exception $e) {
            // Handle exceptions
            echo "An error occurred: " . $e->getMessage(). PHP_EOL;
        }

        return $response;
    }
   
    /**
     * Fetches data to a json file.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
    public static function FetchData(string $jsonData): string
    {
        $fileName = 'flightsData.json';

        try {
            // Fetch API data
            $result = file_put_contents('./public/' . $fileName, $jsonData);
        
            if ($result === false) {
                throw new \Exception("When trying to write data to file.");
            }
        
            // Process the parsed data
            echo "Write data to file succesfully". PHP_EOL;
        
        } catch (\Exception $e) {
            // Handle exceptions
            echo "An error occurred: " . $e->getMessage(). PHP_EOL;
        }

        return $fileName;
    }

    /**
     * Parse data from json file.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
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
        // var_dump($parsedData['header']);
        // die;
    }
}
