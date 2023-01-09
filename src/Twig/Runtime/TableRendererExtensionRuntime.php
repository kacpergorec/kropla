<?php
declare(strict_types=1);

namespace App\Twig\Runtime;

use App\Table\Cell\BooleanCell;
use App\Table\Cell\EmptyCell;
use App\Table\Cell\NumberCell;
use App\Table\Cell\ObjectCell;
use App\Table\Cell\StringCell;
use App\Table\Table;
use Twig\Extension\RuntimeExtensionInterface;

class TableRendererExtensionRuntime implements RuntimeExtensionInterface
{

    private function renderValue($value)
    {
        return match (gettype($value)) {
            'boolean' => BooleanCell::render($value),
            'integer', 'double' => NumberCell::render($value),
            'object' => ObjectCell::render($value),
            'NULL' => EmptyCell::render(),
            default => StringCell::render($value)
        };
    }

    public function renderCell(mixed $value, string $extraParameters = '', bool $isHeader = false): string
    {
        $tag = $isHeader ? 'th' : 'td';

        $output = "<$tag $extraParameters>";
        $output .= $this->renderValue($value);
        $output .= "</$tag>";

        return $output;
    }

    public function renderRow(array $row, string $extraParameters = '', bool $isHeader = false, bool $isVertical = false): string
    {
        $output = "<tr $extraParameters>";

        foreach ($row as $key => $cell) {
            if ($isVertical) {
                $isHeader = (bool) ($key-1);
            }
            $output .= $this->renderCell($cell, $extraParameters, $isHeader);
        }

        $output .= "</tr>";

        return $output;
    }

    private function renderRows(array $rows): string
    {
        $output = '';

        foreach ($rows as $row) {
            $output .= $this->renderRow($row);
        }

        return $output;
    }

    public function renderHead(Table $table, string $extraParameters = ''): string
    {
        $output = '<thead>';
        $output .= $this->renderRow($table->getHeaders(), '', true);
        $output .= '</thead>';

        return $output;
    }

    public function renderBody(Table $table, string $extraParameters = ''): string
    {
        $output = '<tbody>';
        $output .= $this->renderRows($table->getData());
        $output .= '</tbody>';

        return $output;
    }

    public function renderTable(Table $table, string $extraClass = '', string $extraParameters = ''): string
    {

        if ($table->isVertical()) {
            $extraClass .= ' table--vertical';
            return $this->renderVerticalTable($table, $extraClass, $extraParameters);
        }

        $class = $extraClass ? "class='$extraClass'" : '';

        $output = "<table $class $extraParameters>";
        $output .= $this->renderHead($table);
        $output .= $this->renderBody($table);
        $output .= '</table';
        return $output;
    }

    public function renderVerticalTable(Table $table, string $extraClass = '', string $extraParameters = ''): string
    {
        $headers = $table->getHeaders();
        $data = $table->getData();
        $rows = [];

        foreach ($data as $row) {
            $row = array_values($row);
            for ($i = 0, $iMax = count($row); $i < $iMax; $i++) {
                $rows[$i] = $row[$i];
            }
        }

        $class = $extraClass ? "class='$extraClass'" : '';

        $output = "<table $class $extraParameters>";
        $output .= '<tbody>';
        for ($i = 0, $iMax = count($rows); $i < $iMax; $i++) {
            $output .= $this->renderRow([$headers[$i], $rows[$i]], '',false,true);
        }
        $output .= '</tbody>';
        $output .= '</table>';

        return $output;
    }


}
