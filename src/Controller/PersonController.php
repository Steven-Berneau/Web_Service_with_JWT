<?php

namespace App\Controller;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Annotation\Groups;


class PersonController extends AbstractController
{
    // #[Route('/person', name: 'app_person')]
    #[Route('/api/person', name: 'api_person', methods: ['GET'])]
    #[Groups('person:read')]
    public function index(PersonRepository $personRepository, NormalizerInterface $normalizer): Response
    {
        $personnes = $personRepository->findAll();
        $normalized = $normalizer->normalize($personnes, NULL, ['groups' => 'person:read']);
        $json = json_encode($normalized);
        $reponse = new Response($json, 200, ['content-type' => 'application/json']);
        return $reponse;
    }

    #[Route('/api/person/{id}', name: 'api_person_avec_id', methods: ['GET'])]
    #[Groups('person:read')]
    public function findById(PersonRepository $personRepository, $id, NormalizerInterface $normalizer): Response
    {
        $personne = $personRepository->find($id);
        $normalized = $normalizer->normalize($personne, NULL, ['groups' => 'person:read']);

        $json = json_encode($normalized);
        $reponse = new Response($json, 200, ['content-type' => 'application/json']);
        return $reponse;
    }
}
