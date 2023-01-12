<?php
declare (strict_types=1);

namespace App\Helper;

class StringHelper
{
    /**
     * Returns the first matching string from an array of strings
     *
     * @param array<string> $strings The array of strings to search
     * @param array<string> $array The array to search in
     * @return string|null The first matching string, or null if no matches were found.
     */
    public static function getFirstMatchingString(array $strings, array $array) : ?string
    {
        $intersection = array_intersect($strings, $array);

        if (count($intersection) > 0) {
            return reset($intersection);
        }

        return null;
    }

    /**
     * Cuts a string to a specific number of words and adds "..." at the end
     *
     * @param string $string The input string
     * @param int $wordCount The number of words to keep
     * @return string The shortened string
     */
    public static function cutStringToWords($string, int $wordCount): string
    {
        $wordArray = explode(' ', $string);
        if (count($wordArray) > $wordCount) {
            $wordArray = array_slice($wordArray, 0, $wordCount);

            //Remove special characters to avoid 4 trailing dots.
            $lastWord = array_pop($wordArray);
            $wordArray[] = rtrim($lastWord, ',.:');

            $string = implode(' ', $wordArray) . " ...";
        }
        return $string;
    }
}