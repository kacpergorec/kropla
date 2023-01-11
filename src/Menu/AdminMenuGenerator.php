<?php
declare (strict_types=1);

namespace App\Menu;

use App\Controller\Admin\AdminControllerInterface;
use App\Exception\ClassMethodNotImplementedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * A service to generate menu based on Controllers that implement AdminControllerInterface.
 */
class AdminMenuGenerator
{

    private const NAMESPACE = 'App\\Controller';
    private const DIRECTORY = __DIR__ . '/../Controller';
    private const PATTERN = '*Controller.php';
    private const TARGET_METHOD = 'index';

    public function __construct(
        private readonly RouterInterface $router
    )
    {
    }


    /**
     * TODO: Implement caching
     * Matches the application routes with controllers that implement AdminControllerInterface.
     * @return Route[] An array of routes.
     */
    public function getRoutes(): array
    {
        $crudControllers = $this->findCrudControllers();

        $routeCollection = $this->router->getRouteCollection();

        $menuRoutes = [];

        /**
         * @var AdminControllerInterface $crudController
         */
        foreach ($crudControllers as $crudController) {

            $title = $crudController::getPluralName();
//            Foreach is faster than array_filter (stackoverflow.com/q/6791479)
//            $menu[$title] = array_filter((array)$routeCollection, static function (Route $route) use ($crudController) {
//                return $route->getDefault('_controller') === $crudController . '::' . self::TARGET_METHOD;
//            });

            // If registered route has the same FQN::method as CRUD controller FQN::method, save it to menu.
            foreach ($routeCollection as $route) {
                if ($route->getDefault('_controller') === $crudController . '::' . self::TARGET_METHOD) {
                    $menuRoutes[$title] = $this->router->match($route->getPath())['_route'];
                }
            }
        }

        return $menuRoutes;
    }

    /**
     * Finds all the controller FQNs in the given directory.
     * @return string[] - An array of controller names.
     */
    private function getControllers($directory = self::DIRECTORY): array
    {
        $finder = new Finder();
        $finder->files()->in($directory)->name(self::PATTERN);

        $controllers = [];
        foreach ($finder as $file) {

            $controllerPath = [
                self::NAMESPACE,
                $file->getRelativePath(),
                pathinfo($file->getBasename(), PATHINFO_FILENAME)
            ];

            $controllers[] = implode('\\', array_filter($controllerPath));
        }

        return $controllers;
    }

    /**
     * Finds controllers that implement AdminControllerInterface.
     * @return string[] An array of controller FQNs that implement the AdminControllerInterface.
     * @throws ClassMethodNotImplementedException Throws an error if the target method was not found within the class.
     */
    private function findCrudControllers(): array
    {

        return array_filter($this->getControllers(),
            static function ($controller) {

                $interfaces = class_implements($controller);

                $hasInterface = isset($interfaces[AdminControllerInterface::class]);

                if ($hasInterface && !method_exists($controller, self::TARGET_METHOD)) {
                    throw new ClassMethodNotImplementedException($controller, self::TARGET_METHOD);
                }

                return $hasInterface;
            }
        );
    }
}