<?php

namespace App\Blocks;

use Adeliom\EasyGutenbergBundle\Blocks\AbstractBlockType;
use App\Entity\Post;
use App\Form\Type\DefaultSettingsBlockType;
use App\Form\Type\LastPostsType;
use App\Service\PostService;
use App\Service\PostServiceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class HeroType extends AbstractBlockType
{
    public function __construct(protected PostServiceInterface $postService) {}

    public function buildBlock(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('settings', DefaultSettingsBlockType::class, ['required' => false]);

        $builder->add('title', TextType::class, ['label' => 'Title']);
        $builder->add('text', TextEditorType::class, ['label' => 'Text']);
    }

    public static function getName(): string
    {
        return 'Hero';
    }

    public static function getDescription(): string
    {
        return 'Show a hero block with title and text';
    }

    public static function getIcon(): string
    {
        return ' fa fa-light fa-bolt';
    }

    public static function getCategory(): string
    {
        return 'common';
    }

    public static function getTemplate(): string
    {
        return 'blocks/hero.html.twig';
    }

    public static function configureAssets(): array
    {
        return [
            'js' => ['/build/block-hero.js'],
            'css' => ['/build/block-hero.css'],
        ];
    }

    public function render(array $data): array
    {
        return array_merge($data, []);
    }
}