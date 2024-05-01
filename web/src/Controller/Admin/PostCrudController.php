<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Field\BlockField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')->addCssClass('field-title'),
            SlugField::new('slug')->setTargetFieldName('title'),
            AssociationField::new('category'),
            ChoiceField::new('status')->setChoices([
                'Published' => 'published',
                'Private' => 'private',
                'Draft' => 'draft',
            ]),

            BlockField::new('content'),
            IdField::new('id')->onlyOnIndex(),
        ];
    }

    public function createEntity(string $entityFqcn): Post
    {
        $post = new Post();
        $post->setCreatedAtDefault();
        $post->setUpdatedAtDefault();
        $post->setUser($this->getUser());

        return $post;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance = $this->updateEntityInstance($entityInstance);

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    private function updateEntityInstance(Post $entityInstance): Post
    {
        $entityInstance->setUpdatedAtDefault();

        return $entityInstance;
    }
}
