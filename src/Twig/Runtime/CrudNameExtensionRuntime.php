<?php

namespace App\Twig\Runtime;

use App\Admin\Interface\AdminControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class CrudNameExtensionRuntime implements RuntimeExtensionInterface
{
    private Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getCrudName(): string
    {
        $controllerWithMethod = $this->request->get('_controller');

        $substring = "::";
        $pos = strpos($controllerWithMethod, $substring);
        if ($pos === false) {
            return '';
        }

        $controller = substr($controllerWithMethod, 0, $pos);

        if (!is_subclass_of($controller, AdminControllerInterface::class)) {
            return '';
        }

        return $controller::getAdminName();
    }
}
