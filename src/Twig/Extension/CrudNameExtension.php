<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CrudNameExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CrudNameExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_crud_name', [CrudNameExtensionRuntime::class, 'getCrudName']),
        ];
    }
}
