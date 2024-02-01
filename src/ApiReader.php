<?php

/**
 * Class purpose is to make adjustments to $flightsDetails
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Class FlightsDetails modifies flights details.
 */
final class ApiReader
{    
    /**
     * Sends HTTP request to API and gets a response.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
    public static function MakeHttpRequest(array $flightsDetails): bool|string
    {   
        $apiUrl = "http://homeworktask.infare.lt/search.php?from=" .
            $flightsDetails['tripFrom'] . "&to=" . $flightsDetails['tripTo'] .
            "&depart=" . $flightsDetails['departDate'] . "&return=" . $flightsDetails['returnDate'];

        try {
            // Fetch API data
            $response  = file_get_contents($apiUrl);
        
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
    public static function WriteData(string $jsonData, array $flightsDetails): string
    {
        $fileName = $flightsDetails['tripFrom'] . '-' . $flightsDetails['tripTo']
        . '_(' . $flightsDetails['departDate'] . ')-(' . $flightsDetails['returnDate'] . ').json';

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
}
