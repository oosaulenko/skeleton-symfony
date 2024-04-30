<?php

namespace App\Service;

use App\Repository\CategoryRepositoryInterface;
use App\Service\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{

    public function __construct(
        protected CategoryRepositoryInterface $repository
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
    public function findBySlug(string $slug): mixed
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): mixed
    {
        return $this->repository->findById($id);
    }
}