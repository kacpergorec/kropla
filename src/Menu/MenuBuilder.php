<?php
declare (strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
    )
    {
    }

    public function createSideMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'app_home']);
        $menu->addChild('Home1', ['route' => 'app_home']);
        $menu->addChild('Home2', ['route' => 'app_home']);
        $menu->addChild('Home3', ['route' => 'app_home']);

//        foreach ($this->repository->findAll() as $page) {
//            if ($page->isInMenu() && $page->isPublished()) {
//                $menu->addChild($page->getTitle(), [
//                    'route' => 'app_page',
//                    'routeParameters' => ['slug' => $page->getSlug()]
//                ]);
//            }
//        }

        return $menu;
    }
}
