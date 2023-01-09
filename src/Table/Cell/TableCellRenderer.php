<?php
declare (strict_types=1);

namespace App\Table\Cell;

use Twig\Environment;

class TableCellRenderer
{
    public function __construct(private Environment $twig)
    {
    }

    public function render(mixed $value): string
    {
        return match (gettype($value)) {
            'boolean' => BooleanCell::render($value),
            'integer', 'double' => NumberCell::render($value),
            'object' => ObjectCell::render($value, $this->twig),
            'NULL' => EmptyCell::render(),
            default => StringCell::render($value)
        };
    }
}