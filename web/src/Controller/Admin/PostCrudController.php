<?php

namespace App\Controller\Admin;

use Adeliom\EasyGutenbergBundle\Admin\Field\GutenbergField;
use App\Entity\Post;
use App\Field\BlockField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PostCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            // Add the form theme
            ->addFormTheme('@EasyGutenberg/form/gutenberg_widget.html.twig')
            ->showEntityActionsInlined()
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $categoryField = AssociationField::new('category')->setColumns(7);

        if ($pageName === Crud::PAGE_INDEX) {
            $categoryField->formatValue(function ($value, Post $entity) {
                return implode(',', $entity->getCategory()->map(function ($category) {
                    return $category->getTitle();
                })->toArray());
            });
        }

        return [
            FormField::addTab('General'),
            TextField::new('title')
                ->setLabel('Title')
                ->addCssClass('field-title')->setColumns(12)
                ->setHtmlAttribute('placeholder', 'Title'),
            GutenbergField::new('content')->onlyOnForms()->setLabel(false),
            FormField::addTab('Settings')->setIcon('fa fa-cog'),
            SlugField::new('slug')
                ->onlyOnForms()
                ->setTargetFieldName('title')
                ->setColumns(7),
            $categoryField,
            ChoiceField::new('status')->setChoices([
                'Published' => 'published',
                'Private' => 'private',
                'Draft' => 'draft',
            ])->setColumns(7),
            DateField::new('updatedAt')->setLabel('Updated')->onlyOnIndex(),
            DateField::new('createdAt')->setLabel('Created')->onlyOnIndex(),

            IdField::new('id')->onlyOnIndex()->hideOnIndex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewDetailsAction = Action::new('view', 'View')
            ->addCssClass('text-success')
            ->setIcon('fa fa-eye')
            ->setHtmlAttributes(['target' => '_blank'])
            ->linkToRoute('app_post_single', function (Post $entity): array {
                return ['id' => $entity->getId()];
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $viewDetailsAction)
            ->add(Crud::PAGE_EDIT, $viewDetailsAction);
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
