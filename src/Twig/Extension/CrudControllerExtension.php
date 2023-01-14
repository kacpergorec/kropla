<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CrudControllerExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CrudControllerExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_crud_name', [CrudControllerExtensionRuntime::class, 'getCrudName']),
            new TwigFunction('get_crud_description', [CrudControllerExtensionRuntime::class, 'getCrudDescription']),
            new TwigFunction('get_crud_icon', [CrudControllerExtensionRuntime::class, 'getCrudIcon'], ['is_safe' => ['html']]),
        ];
    }
}
