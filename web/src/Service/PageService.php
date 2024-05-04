<?php

namespace App\Service;

use App\Entity\Page;
use App\Repository\PageRepositoryInterface;

class PageService implements PageServiceInterface
{

    public function __construct(
        protected PageRepositoryInterface $repository
    ) { }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->repository->all();
    }

    /**
     * @inheritDoc
     */
    public function findBySlug(string $slug): ?Page
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Page
    {
        return $this->repository->findById($id);
    }

    public function findBySlugAndMain(string $slug = null): ?Page
    {
        if ($slug === null) {
            return $this->repository->findMainPage();
        }

        return $this->findBySlug($slug);
    }
}