<?php

namespace App\Field;

use App\Form\BlockType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Contracts\Translation\TranslatableInterface;

final class BlockField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param TranslatableInterface|string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)

            // this template is used in 'index' and 'detail' pages
            ->setTemplatePath('admin/field/block.html.twig')

            // this is used in 'edit' and 'new' pages to edit the field contents
            // you can use your own form types too
            ->setFormType(BlockType::class)
            ->addCssClass('field-block')
            ->onlyOnForms()
            ->setColumns('col-md-12')

            // loads the CSS and JS assets associated to the given Webpack Encore entry
            // in any CRUD page (index/detail/edit/new). It's equivalent to calling
            // encore_entry_link_tags('...') and encore_entry_script_tags('...')
            ->addWebpackEncoreEntries('admin-field-block')

            // these methods allow to define the web assets loaded when the
            // field is displayed in any CRUD page (index/detail/edit/new)
//            ->addCssFiles('js/admin/field-map.css')
//            ->addJsFiles('js/admin/field-block.js')
            ;
    }
}