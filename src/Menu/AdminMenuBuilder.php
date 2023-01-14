<?php
declare (strict_types=1);

namespace App\Menu;

use App\Cache\CacheManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Routing\Route;

class AdminMenuBuilder
{
    public function __construct(
        private FactoryInterface   $factory,
        private CacheManager       $cacheManager,
        private AdminMenuGenerator $adminMenuGenerator,
    )
    {
    }

    public function createAdminMenu(array $options): ItemInterface
    {
        $routes = $this->cacheManager->get(
            'admin_menu',
            fn() => $this->adminMenuGenerator->getRoutes()
        );

        $mainMenu = $this->factory->createItem('main');

        /**
         * @var $route Route
         */
        foreach ($routes as $route) {
            $mainMenu
                ->addChild($route['title'], [
                    'route' => $route['route'],
                ])
                ->setAttribute('iconClass', $route['iconClass'])
                ->setAttribute('customProperties', $route['customProperties'])
            ;

        }

        return $mainMenu;

    }


}
