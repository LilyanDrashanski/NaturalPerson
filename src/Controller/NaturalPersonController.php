<?php

namespace App\Controller;

use App\Builder\NaturalPersonBuilder;
use App\dto\request\NaturalPersonDto;
use App\dto\request\NaturalPersonUpdateDto;
use App\Entity\NaturalPerson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class NaturalPersonController extends AbstractController
{

    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;

    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }


    public function naturalPersonCreate(Request $request): JsonResponse
    {

        $dto = $this->serializer->deserialize($request->getContent(), NaturalPersonDto::class, 'json');

        $naturalPerson = NaturalPersonBuilder::buildEntity($dto);
        $response = NaturalPersonBuilder::buildNaturalPersonReposeDto($naturalPerson);

        $this->entityManager->persist($naturalPerson);
        $this->entityManager->flush();

        return $this->json($response);
    }

    public function naturalPersonList(): JsonResponse
    {

        $naturalPersons = $this->entityManager->getRepository(NaturalPerson::class)->findAll();

        $response = NaturalPersonBuilder::buildNaturalPersonListDto($naturalPersons);

        return $this->json($response);

    }

    public function naturalPersonGetByToken(string $token): JsonResponse
    {
        $naturalPerson = $this->entityManager->getRepository(NaturalPerson::class)->findByToken($token);

        if ($naturalPerson === null) {
            return $this->json(['error' => 'Natural Person not found'], Response::HTTP_NOT_FOUND);
        }

        $response = naturalPersonBuilder::buildNaturalPersonReposeDto($naturalPerson);

        return $this->json($response);
    }

    public function updateNaturalPerson(string $token, Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), NaturalPersonUpdateDto::class, 'json');

        $naturalPerson = $this->entityManager->getRepository(NaturalPerson::class)->findByToken($token);

        if ($naturalPerson === null) {
            return $this->json(['error' => 'Natural Person not found'], Response::HTTP_NOT_FOUND);
        }

        $naturalPerson = NaturalPersonBuilder::buildEntityUpdate($dto, $naturalPerson);

        $this->entityManager->persist($naturalPerson);
        $this->entityManager->flush();

        $response = naturalPersonBuilder::buildNaturalPersonReposeDto($naturalPerson);

        return $this->json($response);
    }

    public function deleteNaturalPerson(string $token): JsonResponse{
        $naturalPerson = $this->entityManager->getRepository(NaturalPerson::class)->findByToken($token);

        if ($naturalPerson === null) {
            return $this->json(['error' => 'Natural Person not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($naturalPerson);
        $this->entityManager->flush();

        return $this->json(['success' => 'Deleted successfully'], Response::HTTP_OK);
    }

}
