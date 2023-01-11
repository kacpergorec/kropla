<?php
declare (strict_types=1);

namespace App\Helper;

use App\Controller\Admin\AdminControllerInterface;

class RouteHelper
{
    /**
     * Extract the CRUD routes from the route collection of previous controller.
     *
     * @return array An associative array of CRUD route names, keyed by the method name.
     */
    public static function extractCrudRoutesFromPreviousController(): array
    {
        $controllerClass = self::getPreviousUsedCrudController();

        // Define the list of accepted CRUD methods
        $acceptedMethods = ['index', 'delete', 'details', 'edit'];
        $acceptedMethods = array_map(
        // Combine the controller class name with the method name
            fn($method) => $controllerClass::class . '::' . $method,
            array_combine($acceptedMethods, $acceptedMethods)
        );

        $routeCollection = $controllerClass->router->getRouteCollection();
        $crudRoutes = [];

        foreach ($routeCollection->getIterator()->getArrayCopy() as $routeName => $route) {
            $controllerDetails = $route->getDefault('_controller');

            // Check if the current route is a CRUD route
            if (in_array($controllerDetails, $acceptedMethods, true)) {
                $method = array_search($controllerDetails, $acceptedMethods);
                $crudRoutes[$method] = $routeName;
            }
        }

        return $crudRoutes;
    }


    private static function getPreviousUsedCrudController(): AdminControllerInterface
    {
        $trace = debug_backtrace();

        $crudController = array_filter($trace, static function ($stackPoint) {
            if (isset($stackPoint['object'])) {

                $interfaces = class_implements($stackPoint['class']);
                $hasInterface = isset($interfaces[AdminControllerInterface::class]);

                return $hasInterface;
            }
            return false;
        });

        return reset($crudController)['object'];
    }
}