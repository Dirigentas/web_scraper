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
    public static function MakeHttpRequest(): string
    {
        $url = 'http://homeworktask.infare.lt/search.php?from=MAD&to=FUE&depart=2024-02-09&return=2024-02-16';

        // $jsonData = file_get_contents('./public/' . $fileName);
        $jsonData = file_get_contents($url);

        // var_dump(gettype($jsonData));
        // die();

        return $jsonData;
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

        file_put_contents('./public/' . $fileName, $jsonData);

        return $fileName;
    }

    /**
     * Parse data from json file.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
    public static function ParseData(string $fileName): array
    {
        $json = file_get_contents('./public/' . $fileName);

        $data = json_decode($json, true);

        // var_dump($data['header']);
        // die;

        return $parsedData;
    }
}
