<?php
declare (strict_types=1);

namespace App\Menu;

use App\Cache\CacheManager;
use App\Repository\PageRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MainMenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
        private PageRepository   $pageRepository,
        private CacheManager     $cacheManager,
    )
    {
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $pages = $this->cacheManager->get(
            'main_menu',
            fn() => $this->pageRepository->findAllPublishedAndPromoted()
        );

        $mainMenu = $this->factory->createItem('main');

        foreach ($pages as $page) {
            $mainMenu->addChild($page->getTitle(), [
                'route' => 'app_page',
                'routeParameters' => ['slug' => $page->getSlug()],
            ]);
        }

        return $mainMenu;

    }


}
