<?php
declare (strict_types=1);

namespace App\Table\Cell;

class NumberCell
{
    public static function render(int|float $value): string
    {
        return (string) $value;
    }
}