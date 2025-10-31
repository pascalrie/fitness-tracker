<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExerciseApiController extends BaseApiController
{
    #[Route('/exercise/api', name: 'app_exercise_api')]
    public function index(): Response
    {
        return $this->render('exercise_api/index.html.twig', [
            'controller_name' => 'ExerciseApiController',
        ]);
    }
}
