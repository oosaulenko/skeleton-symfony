<?php

namespace App\Repository;

use App\Entity\Page;

interface PageRepositoryInterface
{
    /**
     * @return Page[]
     */
    public function all(): array;

    /**
     * @param string $slug
     * @return Page|null
     */
    public function findBySlug(string $slug): ?Page;

    /**
     * @param int $id
     * @return Page|null
     */
    public function findById(int $id): ?Page;

    /**
     * @return Page|null
     */
    public function findMainPage(): ?Page;

}