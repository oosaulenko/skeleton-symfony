<?php

namespace App\Service;

interface PostServiceInterface
{

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug): mixed;

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id): mixed;
}