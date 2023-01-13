<?php
declare (strict_types=1);

namespace App\Helper;

class ArrayHelper
{

    public static function arrayHasCustomKeys(array $array) : bool
    {

        $result = true;
        foreach ( array_keys($array) as $i => $key) {
            if ($key !== $i) {
                $result = false;
                break;
            }
        }
        return !$result;
    }
}