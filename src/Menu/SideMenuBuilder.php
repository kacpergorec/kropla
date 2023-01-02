<?php
declare (strict_types=1);

namespace App\Menu;

use App\Repository\CategoryRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class SideMenuBuilder
{
    public function __construct(
        private FactoryInterface   $factory,
        private CategoryRepository $categoryRepository
    )
    {
    }

    public function createSideMenu(array $options): ItemInterface
    {
        $sideMenu = $this->factory->createItem('side');

        $categories = $this->categoryRepository->withPublishedChildPagesNotPromoted();

        foreach ($categories as $category) {
            $categoryTitle = $category->getTitle();

            $sideMenu->addChild($categoryTitle);

            foreach ($category->getPages() as $page) {
                $sideMenu[$categoryTitle]->addChild($page->getTitle(), [
                        'route' => 'app_home',
                        'routeParameters' => ['slug' => $page->getSlug()],
                        ]
                );
            }
        }

        return $sideMenu;
    }

}
