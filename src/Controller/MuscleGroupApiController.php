<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MuscleGroupApiController extends BaseApiController
{
    #[Route('/muscle/group/api', name: 'app_muscle_group_api')]
    public function index(): Response
    {
        return $this->render('muscle_group_api/index.html.twig', [
            'controller_name' => 'MuscleGroupApiController',
        ]);
    }
}
