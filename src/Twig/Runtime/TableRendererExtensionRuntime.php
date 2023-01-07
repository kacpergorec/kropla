<?php
declare(strict_types=1);

namespace App\Twig\Runtime;

use App\Table\Table;
use Twig\Extension\RuntimeExtensionInterface;

class TableRendererExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function renderCell(mixed $value, string $extraParameters = '', bool $isHeader = false): string
    {
        $tag = $isHeader ? 'th' : 'td';

        $output = "<$tag $extraParameters>";
        $output .= $value;
        $output .= "</$tag>";

        return $output;
    }

    public function renderRow(array $row, string $extraParameters = '', bool $isHeader = false): string
    {
        $output = "<tr $extraParameters>";

        foreach ($row as $cell) {
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

    public function renderTable(Table $table,string $extraClass = '', string $extraParameters = ''): string
    {
        $class = $extraClass ? "class='$extraClass'" : '';

        $output = "<table $class $extraParameters>";
        $output .= $this->renderHead($table);
        $output .= $this->renderBody($table);
        $output .= '</table';
        return $output;
    }
}
