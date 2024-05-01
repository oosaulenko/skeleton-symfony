<?php

namespace App\Controller\API\admin\field;

use App\Controller\API\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FieldBlockController extends ApiController
{
    #[Route('/api/admin/field/block', name: 'api_admin_field_block')]
    public function index(): Response
    {
        return $this->json([]);
    }


}
