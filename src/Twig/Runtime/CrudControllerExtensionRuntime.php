<?php

namespace App\Twig\Runtime;

use App\Admin\Interface\AdminControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class CrudControllerExtensionRuntime implements RuntimeExtensionInterface
{
    private Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getCrudName(): string
    {
        $controller = $this->getCurrentCrudController();

        return $controller::getAdminMetadata()->getLabel();
    }


    public function getCrudIcon(string $extraClasses = ''): string
    {
        $controller = $this->getCurrentCrudController();

        $iconClass = $controller::getAdminMetadata()->getIconClass();
        $classes = implode(' ', [$iconClass, $extraClasses]);


        return "<i class=\"$classes\"></i>";
    }

    public function getCrudDescription(): string
    {
        $controller = $this->getCurrentCrudController();

        return $controller::getAdminMetadata()->getDescription();
    }


    private function getCurrentCrudController()
    {
        $controllerWithMethod = $this->request->get('_controller');

        $substring = "::";
        $pos = strpos($controllerWithMethod, $substring);

        $controller = substr($controllerWithMethod, 0, $pos);

        if (!is_subclass_of($controller, AdminControllerInterface::class)) {
            return throw new \Exception(
                "Controller {$controller} that the CRUD helper twig function is referring to to is not an subclass of AdminControllerInterface"
            );
        }

        return $controller;
    }
}
