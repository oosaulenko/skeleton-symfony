<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Menu;
use App\Entity\Page;
use App\Entity\Post;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Skeleton panel')
            ;
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addWebpackEncoreEntry('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('<hr style="margin: 0;">');
        yield MenuItem::linkToCrud('Pages', 'fa fa-file-lines', Page::class);
        yield MenuItem::section('<hr style="margin: 0;">');
        yield MenuItem::linkToCrud('Posts', 'fa fa-file-lines', Post::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class);

        yield MenuItem::section('<hr style="margin: 0;">');
        yield MenuItem::linkToRoute('Medias', 'fa fa-picture-o', 'oosaulenko_media_list');
        yield MenuItem::linkToCrud('Menus', 'fa fa-bars-staggered', Menu::class);


        yield MenuItem::section('<hr style="margin: 0;">');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
