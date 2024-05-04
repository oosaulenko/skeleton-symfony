<?php

namespace App\Controller\Admin;

use Adeliom\EasyGutenbergBundle\Admin\Field\GutenbergField;
use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->addFormTheme('@EasyGutenberg/form/gutenberg_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('General'),
            TextField::new('title')
                ->setLabel(false)
                ->setHtmlAttribute('placeholder', 'Title')
                ->addCssClass('field-title')
                ->setColumns(12),
            GutenbergField::new('content')->hideOnIndex()->setLabel(false),

            FormField::addTab('Settings')->setIcon('fa fa-cog'),
            SlugField::new('slug')->setTargetFieldName('title'),
            BooleanField::new('main')
                ->setLabel('Is main page?')
                ->setHelp('This page will be the main page of the website.'),

            ChoiceField::new('status')->setChoices([
                'Published' => 'published',
                'Private' => 'private',
                'Draft' => 'draft',
            ]),
        ];
    }

    public function createEntity(string $entityFqcn): Page
    {
        $post = new Page();
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

    private function updateEntityInstance(Page $entityInstance): Page
    {
        $entityInstance->setUpdatedAtDefault();

        return $entityInstance;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}