<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SetApiController extends BaseApiController
{
    #[Route('/set/api', name: 'app_set_api')]
    public function index(): Response
    {
        return $this->render('set_api/index.html.twig', [
            'controller_name' => 'SetApiController',
        ]);
    }
}
