<?php

/**
 * File purpose is to read file data.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount;

/**
 * Class FileReader reads data from the file.
 */
class FileReader
{
    /**
     * Reads data from a file.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return string String of transactions from input.txt.
     */
    public static function getFileData(string $fileName): string
    {
        $input = file_get_contents('./public/' . $fileName);

        return $input;
    }

    /**
     * Explodes string of transactions to array of arrays.
     *
     * @param string $input String of transactions.
     *
     * @return array[] An array of array transactions.
     */
    public static function makeTransactionArray(string $input): array
    {
        $input = explode("\n", $input); // Linux
        // $input = explode("\r\n", $input); Windows

        foreach ($input as &$transaction) {
            $transaction = explode(" ", $transaction);
        }
        return $input;
    }
}
