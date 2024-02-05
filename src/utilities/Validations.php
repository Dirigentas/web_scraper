<?php

declare(strict_types=1);

namespace Aras\WebScraper\utilities;

final class Validations
{
    /**
     * Validates the parsed search criteria array to ensure all required parameters are present.
     *
     * @param array $parsedSearchCriteria The parsed search criteria array to be validated.
     * @return void
     */
    public static function searchCriteriaValidation(array $parsedSearchCriteria): void
    {
        foreach ($parsedSearchCriteria as $searchId => $searchCriteria) {
            if (
                $searchCriteria['tripFrom'] == "" ||
                $searchCriteria['tripTo'] == "" ||
                $searchCriteria['departDate']['year'] == "" ||
                $searchCriteria['departDate']['month'] == "" ||
                $searchCriteria['departDate']['day'] == "" ||
                $searchCriteria['returnDate']['year'] == "" ||
                $searchCriteria['returnDate']['month'] == "" ||
                $searchCriteria['returnDate']['day'] == ""
            ) {
                    echo "Please enter all " . $searchId . " parameters\n";
                    exit(1);
            }
        }
    }
}
