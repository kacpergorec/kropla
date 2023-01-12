<?php
declare (strict_types=1);

namespace App\Table\Cell;

class ArrayCell
{
    public static function render(array $array): string
    {
        return (string) count($array);
    }
}