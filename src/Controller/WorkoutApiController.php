<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WorkoutApiController extends BaseApiController
{
    #[Route('/workout/api', name: 'app_workout_api')]
    public function index(): Response
    {
        return $this->render('workout_api/index.html.twig', [
            'controller_name' => 'WorkoutApiController',
        ]);
    }
}
