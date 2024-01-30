<?php

/**
 * File purpose is to call all required methods.
 */

declare(strict_types=1);

namespace Aras\WebScraper;

use Aras\WebScraper\FlightsDetails;
use Aras\WebScraper\ApiReader;
use Aras\WebScraper\dataFilter\FlightDataExtracter;

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
        $flightDetails = FlightsDetails::AirportAndDatesChooser();

        $response = ApiReader::MakeHttpRequest($flightDetails);

        $fetchedData = ApiReader::FetchData($response);

        $parsedData = ApiReader::ParseData($fetchedData);

        FlightDataExtracter::OutboundFlights($parsedData);

        // $output = DataValidation::addShipmentPrices($output, $this->couriersDetails);

        // $output = LowestPriceFinder::matchLowestProviderPrice($output, $this->couriersDetails);

        // $output = MonthlyPromotion::freeOncePerMonth($output, $this->couriersDetails);

        // $output = DiscountLimiter::limitsDiscounts($output);

        // $output = Formatting::formatShipmentPrice($output);

        // $output = Formatting::formatShipmentDiscount($output);

        // self::writeToStdout($output);
    }
}
