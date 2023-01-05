<?php
declare (strict_types=1);

namespace App\Menu;

use Knp\Menu\ItemInterface;

class MenuProvider
{

    public function __construct(
        private MainMenuBuilder  $mainMenuBuilder,
        private SideMenuBuilder  $sideMenuBuilder,
        private AdminMenuBuilder $adminMenuBuilder
    )
    {
    }

    public function getMainMenu(array $options): ItemInterface
    {
        return $this->mainMenuBuilder->createMainMenu($options);
    }

    public function getSideMenu(array $options): ItemInterface
    {
       return $this->sideMenuBuilder->createSideMenu($options);
    }

    public function getAdminMenu(array $options): ItemInterface
    {
        return $this->adminMenuBuilder->createAdminMenu($options);
    }
}