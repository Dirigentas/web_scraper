<?php

/**
 * Represents a class for reading data from an API and writing it to a file.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

/**
 * Represents a class for reading data from an API and writing it to a file.
 */
class ApiReader
{    
    /**
     * Sends an HTTP request to the API and retrieves a response.
     *
     * @param array $FlightRequestParams An array containing details of the flights, including departure and arrival airports,
     * departure and return dates.
     * @return bool|string Returns the response from the API as a string on success, or false on failure.
     */
    public static function MakeHttpRequest(array $FlightRequestParams): bool|string
    {   
        $apiUrl = "http://homeworktask.infare.lt/search.php?from=" .
            $FlightRequestParams['tripFrom'] . "&to=" . $FlightRequestParams['tripTo'] .
            "&depart=" . $FlightRequestParams['departDate'] . "&return=" . $FlightRequestParams['returnDate'];

        try {
            $response  = file_get_contents($apiUrl);
        
            if ($response === false) {
                throw new \Exception("While fetching API");
            }
            echo "Fetched API data succesfully.". PHP_EOL;
        
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage(). PHP_EOL;
        }
        return $response;
    }
   
    /**
     * Writes data to a json file.
     *
     * @param string $jsonData The JSON data to write to the file.
     * @param array $FlightRequestParams An array containing details of the flights, including departure and arrival airports,
     * departure and return dates.
     * @return string Returns the name of the JSON file that was written.
     */
    public static function WriteData(string $jsonData, array $FlightRequestParams): string
    {
        $fileName = $FlightRequestParams['tripFrom'] . '-' . $FlightRequestParams['tripTo']
        . '_(' . $FlightRequestParams['departDate'] . ')-(' . $FlightRequestParams['returnDate'] . ').json';

        try {
            $result = file_put_contents('./public/' . $fileName, $jsonData);
        
            if ($result === false) {
                throw new \Exception("When trying to write data to file.");
            }
            echo "Write data to file succesfully". PHP_EOL;
        
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage(). PHP_EOL;
        }

        return $fileName;
    }
}
