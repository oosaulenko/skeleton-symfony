<?php

namespace App\Controller\Web\Post;

use Adeliom\EasyGutenbergBundle\Blocks\Block;
use Adeliom\EasyGutenbergBundle\Blocks\BlockTypeRegistry;
use Adeliom\EasyGutenbergBundle\Blocks\ContentRenderer;
use Adeliom\EasyGutenbergBundle\Requests\BlockRenderRequest;
use App\Service\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SinglePostController extends AbstractController
{

    public function __construct(protected PostServiceInterface $postService) { }

    #[Route('/post/{id}', name: 'app_post_single')]
    public function index(int $id): Response
    {
        $post = $this->postService->findById($id);



        return $this->render('web/post/single.html.twig', [
            'post' => $post,
        ]);
    }
}
