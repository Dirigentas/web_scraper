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
     * @param array $formattedSearchCriteria An array containing details of the flights, including departure and arrival airports,
     * departure and return dates.
     * @return bool|string Returns the response from the API as a string on success, or false on failure.
     */
    public static function MakeHttpRequest(array $formattedSearchCriteria): bool|string
    {   
        foreach ($formattedSearchCriteria as $key => $singleSearch) {

            $apiUrl = "http://homeworktask.infare.lt/search.php?from=" .
            $singleSearch['tripFrom'] . "&to=" . $singleSearch['tripTo'] .
            "&depart=" . $singleSearch['departDate'] . "&return=" . $singleSearch['returnDate'];

            try {
                $response[$key]  = file_get_contents($apiUrl);
            
                if ($response === false) {
                    throw new \Exception("While fetching API");
                }
                echo "Fetched API data succesfully.". PHP_EOL;
            
            } catch (\Exception $e) {
                echo "An error occurred: " . $e->getMessage(). PHP_EOL;
            }
        }
        

        // print_r($response);
        // die;
        return $response;
    }
   
    /**
     * Writes data to a json file.
     *
     * @param string $jsonData The JSON data to write to the file.
     * @param array $formattedSearchCriteria An array containing details of the flights, including departure and arrival airports,
     * departure and return dates.
     * @return string Returns the name of the JSON file that was written.
     */
    public static function WriteData(string $jsonData, array $formattedSearchCriteria): string
    {
        $fileName = $formattedSearchCriteria['tripFrom'] . '-' . $formattedSearchCriteria['tripTo']
        . '_(' . $formattedSearchCriteria['departDate'] . ')-(' . $formattedSearchCriteria['returnDate'] . ').json';

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
