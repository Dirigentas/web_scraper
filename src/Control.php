<?php

/**
 * File purpose is to call all required methods.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

use Aras\WebScraper\FlightsDetails;
// use Aras\WebScraper\FileReader;
// use Aras\WebScraper\DataValidation;
// use Aras\WebScraper\calculations\LowestPriceFinder;
// use Aras\WebScraper\calculations\MonthlyPromotion;
// use Aras\WebScraper\calculations\DiscountLimiter;

/**
 * Class Control controls all pats of the solution.
 */
final class Control
{
    /**
     * This method executes all needed classes.
     *
     * @return void
     */
    public function executeAllClasses(): void
    {
        $request = FlightsDetails::MakeHttpRequest();

        $fetchedData = FlightsDetails::FetchData($request);

        $parsedData = FlightsDetails::ParseData($fetchedData);

        // $input = FileReader::getFileData('input.txt');

        // $input = FileReader::makeTransactionArray($input);

        // $output = DataValidation::dataVerification($input, $this->couriersDetails, $this->inputDataStructure);

        // $output = DataValidation::addShipmentPrices($output, $this->couriersDetails);

        // $output = LowestPriceFinder::matchLowestProviderPrice($output, $this->couriersDetails);

        // $output = MonthlyPromotion::freeOncePerMonth($output, $this->couriersDetails);

        // $output = DiscountLimiter::limitsDiscounts($output);

        // $output = Formatting::formatShipmentPrice($output);

        // $output = Formatting::formatShipmentDiscount($output);

        // self::writeToStdout($output);
    }

    /**
     * This method writes the $output to stdout.
     *
     * @param $output The array of transactions with calculated discounts.
     *
     * @return void
     */
    // public static function writeToStdout(array $output): void
    // {
    //     foreach ($output as &$transaction) {
    //         $transaction = implode(' ', $transaction);
    //     }

    //     $output = implode("\r\n", $output);

    //     $stdout = fopen('php://stdout', 'w');
    //     fwrite($stdout, $output);
    //     fclose($stdout);
    // }
}
