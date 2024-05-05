<?php

namespace App\Repository;

use App\Entity\Menu;

interface MenuRepositoryInterface
{

    /**
     * @param string $location
     * @return ?Menu
     */
    public function getMenu(string $location): ?Menu;

}