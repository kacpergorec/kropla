<?php
declare (strict_types=1);

namespace App\Table\Cell;

class BooleanCell
{
    public static function render(bool $value): string
    {
        $state = $value ? 'table__bool--on' : 'table__bool--off';

        return "<span class='table__bool $state'></span>";
    }
}