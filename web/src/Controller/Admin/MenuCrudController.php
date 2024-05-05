<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Form\Type\MenuItemType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menu::class;
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
            CollectionField::new('items')
                ->setEntryType(MenuItemType::class)
                ->hideOnIndex()
                ->addCssClass('field-collection-sortable')
                ->setColumns(12),

            FormField::addTab('Settings')->setIcon('fa fa-cog'),
            ChoiceField::new('location')->setChoices([
                'Header' => 'header',
                'Footer' => 'footer',
            ]),
        ];
    }

    public function createEntity(string $entityFqcn): Menu
    {
        $menu = new Menu();
        $menu->setCreatedAtDefault();
        $menu->setUpdatedAtDefault();
        $menu->setUser($this->getUser());

        return $menu;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance = $this->updateEntityInstance($entityInstance);

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    private function updateEntityInstance(Menu $entityInstance): Menu
    {
        $entityInstance->setUpdatedAtDefault();

        return $entityInstance;
    }
}
