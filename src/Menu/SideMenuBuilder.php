<?php
declare (strict_types=1);

namespace App\Menu;

use App\Cache\CacheManager;
use App\Repository\CategoryRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;

class SideMenuBuilder
{
    public function __construct(
        private FactoryInterface   $factory,
        private CategoryRepository $categoryRepository,
        private CacheManager       $cacheManager,
    )
    {
    }

    public function createSideMenu(array $options): ItemInterface
    {

        $sideMenu = $this->factory->createItem('side');

        $categories = $this->cacheManager->get(
            'side_menu',
            fn() => $this->categoryRepository->withPublishedChildPagesNotPromoted()
        );


        foreach ($categories as $category) {

            $categoryTitle = $category->getTitle();

            $sideMenu->addChild($categoryTitle);

            foreach ($category->getPages() as $page) {
                $sideMenu[$categoryTitle]->addChild($page->getTitle(), [
                        'route' => 'app_page',
                        'routeParameters' => ['slug' => $page->getSlug()],
                    ]
                );

            }
        }

        return $sideMenu;
    }

}
