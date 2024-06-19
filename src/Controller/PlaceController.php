<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class PlaceController extends AbstractController
{
    // #[Route('/place', name: 'app_place')]
    #[Route('/api/place', name: 'api_place', methods: ['GET'])]
    public function index(PlaceRepository $placeRepository, NormalizerInterface $normalizer): Response
    {
        $places = $placeRepository->findall();
        $normalized = $normalizer->normalize($places, NULL, ['groups' => 'place:read']);
        $json = json_encode($normalized);
        $reponse = new Response($json, 200, ['content-type' => 'application/json']);
        return $reponse;
    }

    #[Route('/api/place/{id}', name: 'api_place_avec_id', methods: ['GET'])]
    public function findById(PlaceRepository $placeRepository, $id, NormalizerInterface $normalizer): Response
    {
        $place = $placeRepository->find($id);
        $normalized = $normalizer->normalize($place, NULL, ['groups' => 'place:read']);

        $json = json_encode($normalized);
        $reponse = new Response($json, 200, ['content-type' => 'application/json']);
        return $reponse;
    }
}
