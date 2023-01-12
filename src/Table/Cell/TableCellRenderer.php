<?php
declare (strict_types=1);

namespace App\Table\Cell;

use Twig\Environment;
use UnexpectedValueException;

class TableCellRenderer
{
    public function __construct(private Environment $twig)
    {
    }

    public function render(mixed $value): string
    {
        $type = gettype($value);

        return match ($type) {
            'boolean' => BooleanCell::render($value),
            'integer', 'double' => NumberCell::render($value),
            'object' => ObjectCell::render($value, $this->twig),
            'string' => StringCell::render($value),
            'NULL' => EmptyCell::render(),
            'array' => ArrayCell::render($value),
            default => throw new UnexpectedValueException("Table cell of the type $type is not supported")
        };
    }
}