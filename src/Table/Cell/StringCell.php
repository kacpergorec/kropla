<?php
declare (strict_types=1);

namespace App\Table\Cell;

use App\Helper\StringHelper;

class StringCell
{
    private const WORD_LIMIT = 10;

    public static function render(string $string): string
    {
        //normalize string
        $string = strip_tags($string);

        if (str_word_count($string) > self::WORD_LIMIT + 4) {
            return StringHelper::cutStringToWords($string,self::WORD_LIMIT);
        }
        
        return $string;
    }

}