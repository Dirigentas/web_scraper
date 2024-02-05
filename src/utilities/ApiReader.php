<?php

/**
 * Represents a class for reading data from an API and writing it to a file.
 */

declare(strict_types=1);

namespace Aras\WebScraper\utilities;

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
     * @return array Returns the response from the API and puts into array element.
     */
    public static function MakeHttpRequest(array $formattedSearchCriteria): array
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
            
            } catch (\Exception $e) {
                echo "An error occurred: " . $e->getMessage(). PHP_EOL;
            }
        }
        return $response;
    }
   
    /**
     * Writes data to a json file.
     *
     * @param string $searchId String containing ID of the current search.
     * @param string $searchData The JSON data to write to the file.
     * @return string Returns the name of the JSON file that was written.
     */
    public static function WriteData(string $searchId, string $searchData): string
    {
        $fileName = $searchId . '.json';

        try {
            $result = file_put_contents('./public/' . $fileName, $searchData);
        
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
