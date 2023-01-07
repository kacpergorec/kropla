<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TableRendererExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TableRendererExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
//            new TwigFilter('table_cell_render', [TableRendererExtensionRuntime::class, 'doSomething'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('tr_table_render_cell', [TableRendererExtensionRuntime::class, 'renderCell'], ['is_safe' => ['html']]),
            new TwigFunction('tr_table_render_row', [TableRendererExtensionRuntime::class, 'renderRow'], ['is_safe' => ['html']]),
            new TwigFunction('tr_table_render_head', [TableRendererExtensionRuntime::class, 'renderHead'], ['is_safe' => ['html']]),
            new TwigFunction('tr_table_render_body', [TableRendererExtensionRuntime::class, 'renderBody'], ['is_safe' => ['html']]),
            new TwigFunction('tr_table_render', [TableRendererExtensionRuntime::class, 'renderTable'], ['is_safe' => ['html']]),
        ];
    }
}
