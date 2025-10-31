<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BodyMeasurementApiController extends BaseApiController
{
    #[Route('/body/measurement/api', name: 'app_body_measurement_api')]
    public function index(): Response
    {
        return $this->render('body_measurement_api/index.html.twig', [
            'controller_name' => 'BodyMeasurementApiController',
        ]);
    }
}
