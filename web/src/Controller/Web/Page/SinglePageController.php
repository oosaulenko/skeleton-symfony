<?php

namespace App\Controller\Web\Page;

use App\Service\PageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SinglePageController extends AbstractController
{

    public function __construct(protected PageServiceInterface $pageService) { }

    #[Route('/{slug}', name: 'app_page_single')]
    public function index(string $slug = null): Response
    {
        $page = $this->pageService->findBySlugAndMain($slug);

        if (!$page) {
            throw $this->createNotFoundException();
        }

        try {
            return $this->render('web/page/single-' . $page->getSlug() . '.html.twig', [
                'page' => $page,
            ]);
        } catch (\Throwable $th) {
            return $this->render('web/page/single.html.twig', [
                'page' => $page,
            ]);
        }
    }
}
