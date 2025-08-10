<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleMaker;
use App\Repository\VehicleMakerRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/vehicles')]
class VehicleController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private VehicleRepository $vehicleRepository;
    private VehicleMakerRepository $vehicleMakerRepository;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        VehicleRepository $vehicleRepository,
        VehicleMakerRepository $vehicleMakerRepository,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleMakerRepository = $vehicleMakerRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Endpoint for retrieving all vehicle makers manufacturing a specific type of vehicle.
     * Example: GET /api/vehicles/makers?type=sedan
     */
    #[Route('/makers', name: 'get_makers_by_vehicle_type', methods: ['GET'])]
    public function getMakersByVehicleType(Request $request): JsonResponse
    {
        $type = $request->query->get('type');
        if (!$type) {
            return $this->json(['error' => 'Vehicle type is required.'], Response::HTTP_BAD_REQUEST);
        }

        $makers = $this->vehicleMakerRepository->findMakersByVehicleType($type);

        return $this->json($makers, Response::HTTP_OK);
    }

    /**
     * Endpoint for retrieving all technical details of a specific vehicle.
     * Example: GET /api/vehicles/1
     */
    #[Route('/{id}', name: 'get_vehicle_details', methods: ['GET'])]
    public function getVehicleDetails(int $id): JsonResponse
    {
        $vehicle = $this->vehicleRepository->find($id);

        if (!$vehicle) {
            return $this->json(['error' => 'Vehicle not found.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($vehicle, Response::HTTP_OK);
    }

    /**
     * Endpoint for updating a specific technical parameter of a vehicle.
     * Example: PATCH /api/vehicles/1
     * Body: {"topSpeed": 250}
     */
    #[Route('/{id}', name: 'update_vehicle_parameter', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')] // Restrict to authorized users
    public function updateVehicleParameter(int $id, Request $request): JsonResponse
    {
        $vehicle = $this->vehicleRepository->find($id);

        if (!$vehicle) {
            return $this->json(['error' => 'Vehicle not found.'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json(['error' => 'Invalid JSON body.'], Response::HTTP_BAD_REQUEST);
        }

        // Deserialize the request data onto the existing Vehicle object
        $this->serializer->deserialize(
            $request->getContent(),
            Vehicle::class,
            'json',
            ['object_to_populate' => $vehicle, 'groups' => 'vehicle:update']
        );

        // Validate the updated vehicle object
        $errors = $this->validator->validate($vehicle);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json($vehicle, Response::HTTP_OK, [], ['groups' => 'vehicle:read']);
    }
}