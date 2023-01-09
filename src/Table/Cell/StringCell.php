<?php
declare (strict_types=1);

namespace App\Table\Cell;

class StringCell
{
    public static function render(string $value): string
    {
        return (string) $value;
    }
}