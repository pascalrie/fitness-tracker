<?php

namespace App\Controller;

use App\Service\BodyMeasurementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BodyMeasurementApiController extends BaseApiController
{
    protected BodyMeasurementService $bodyMeasurementService;

    public function __construct(EntityManagerInterface $entityManager, BodyMeasurementService $bodyMeasurementService)
    {
        parent::__construct($entityManager);
        $this->bodyMeasurementService = $bodyMeasurementService;
    }

    #[Route('/body/measurement/api/create', name: 'create_body_measurement_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = json_decode($request->getContent());
        $fitnessEvaluation = (int) $bodyParameters->fitnessEvaluation;
        $bodyWeight = (float) $bodyParameters->bodyWeight;
        $bodyHeight = (float) $bodyParameters->bodyHeight;

        $bmi = $this->bodyMeasurementService->calculateBmi($bodyWeight, $bodyHeight);

        $bodyMeasurement = $this->bodyMeasurementService->create($fitnessEvaluation, $bodyWeight, $bodyHeight, $bmi);
        return $this->json($bodyMeasurement->jsonSerialize(), Response::HTTP_CREATED);
    }

    #[Route('/body/measurement/api/list', name: 'list_body_measurement_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $bodyMeasurements = $this->bodyMeasurementService->list();
        $measurements = [];
        foreach ($bodyMeasurements as $bodyMeasurement) {
            $measurements[] = $bodyMeasurement->jsonSerialize();
        }
        return $this->json($measurements, Response::HTTP_OK);
    }

    #[Route('/body/measurement/api/show/{id}', name: 'show_body_measurement_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $bodyMeasurement = $this->bodyMeasurementService->show($id);
        return $this->json($bodyMeasurement->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/body/measurement/api/update/{id}', name: 'update_body_measurement_api', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $bodyParameters = json_decode($request->getContent());
        $fitnessEvaluation = (int) $bodyParameters->fitnessEvaluation;
        $bodyWeight = (float) $bodyParameters->bodyWeight;
        $bodyHeight = (float) $bodyParameters->bodyHeight;

        $bmi = $this->bodyMeasurementService->calculateBmi($bodyWeight, $bodyHeight);
        $this->bodyMeasurementService->update($id, $bodyWeight, $bmi, $fitnessEvaluation, $bodyHeight);
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/body/measurement/api/delete/{id}', name: 'delete_body_measurement_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->bodyMeasurementService->delete($id);
        $shouldBeNull = $this->bodyMeasurementService->show($id);
        if ($shouldBeNull) {
            return $this->json("Deletion was successful.", Response::HTTP_OK);
        }
        return $this->json("Deletion failed.", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
