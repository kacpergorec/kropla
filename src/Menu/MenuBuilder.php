<?php
declare (strict_types=1);

namespace App\Menu;

use App\Repository\CategoryRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
        private CategoryRepository $categoryRepository
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


        return $menu;
    }
}
