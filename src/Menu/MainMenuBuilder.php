<?php
declare (strict_types=1);

namespace App\Menu;

use App\Repository\CategoryRepository;
use App\Repository\PageRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MainMenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
        private PageRepository   $pageRepository
    )
    {
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $mainMenu = $this->factory->createItem('main');

        $pages = $this->pageRepository->findAllPublishedAndPromoted();


        foreach ($pages as $page) {
            $mainMenu->addChild($page->getTitle(), [
                'route' => 'app_home',
                'routeParameters' => ['slug' => $page->getSlug()],
            ]);
        }

        return $mainMenu;

    }


}
