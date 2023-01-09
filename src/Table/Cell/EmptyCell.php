<?php
declare (strict_types=1);

namespace App\Table\Cell;

class EmptyCell
{
    public static function render(): string
    {
        return "<span class='table__empty-cell'></span>";
    }
}