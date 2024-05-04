<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 */
class PageRepository extends ServiceEntityRepository implements PageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function all(): array
    {
        return self::findAll();
    }

    public function findBySlug($slug): ?Page
    {
        return self::findOneBy(['slug' => $slug]);
    }

    public function findById($id): ?Page
    {
        return self::findOneBy(['id' => $id]);
    }

    public function findMainPage(): ?Page
    {
        return self::findOneBy(['is_main' => true]);
    }
}
