<?php

namespace App\Service;

use App\Entity\Menu;
use App\Repository\MenuRepositoryInterface;

class MenuService implements MenuServiceInterface
{

    public function __construct(
        protected MenuRepositoryInterface $repository
    ) { }

    public function getMenu(string $location): ?Menu
    {
        return $this->repository->getMenu($location);
    }
}