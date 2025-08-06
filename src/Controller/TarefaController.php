<?php

namespace App\Controller;

use App\Entity\Tarefa;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class TarefaController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/tarefas', name: 'tarefa_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['titulo'])) {
            return new JsonResponse(['error' => 'O campo "titulo" é obrigatório.'], Response::HTTP_BAD_REQUEST);
        }

        $tarefa = new Tarefa();
        $tarefa->setTitulo($data['titulo']);
        $tarefa->setDescricao($data['descricao'] ?? null);

        $this->entityManager->persist($tarefa);
        $this->entityManager->flush();

        return new JsonResponse(
            [
                'id' => $tarefa->getId(),
                'titulo' => $tarefa->getTitulo(),
                'descricao' => $tarefa->getDescricao(),
                'concluida' => $tarefa->isConcluida(),
                'dataCriacao' => $tarefa->getDataCriacao()->format('Y-m-d H:i:s'),
            ],
            Response::HTTP_CREATED
        );
    }

    #[Route('/tarefas', name: 'tarefa_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $tarefas = $this->entityManager->getRepository(Tarefa::class)->findAll();

        $data = [];
        foreach ($tarefas as $tarefa) {
            $data[] = [
                'id' => $tarefa->getId(),
                'titulo' => $tarefa->getTitulo(),
                'descricao' => $tarefa->getDescricao(),
                'concluida' => $tarefa->isConcluida(),
                'dataCriacao' => $tarefa->getDataCriacao()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/tarefas/{id}', name: 'tarefa_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $tarefa = $this->entityManager->getRepository(Tarefa::class)->find($id);

        if (!$tarefa) {
            return new JsonResponse(['error' => 'Tarefa não encontrada.'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $tarefa->getId(),
            'titulo' => $tarefa->getTitulo(),
            'descricao' => $tarefa->getDescricao(),
            'concluida' => $tarefa->isConcluida(),
            'dataCriacao' => $tarefa->getDataCriacao()->format('Y-m-d H:i:s'),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/tarefas/{id}', name: 'tarefa_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $tarefa = $this->entityManager->getRepository(Tarefa::class)->find($id);

        if (!$tarefa) {
            return new JsonResponse(['error' => 'Tarefa não encontrada.'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (!empty($data['titulo'])) {
            return new JsonResponse(['error' => 'O campo "titulo" é obrigatório.'], Response::HTTP_BAD_REQUEST);
        }

        $tarefa->setTitulo($data['titulo']);
        $tarefa->setDescricao($data['descricao'] ?? null);
        $tarefa->setConcluida($data['concluida'] ?? $tarefa->isConcluida());

        $this->entityManager->flush();

        $data = [
            'id' => $tarefa->getId(),
            'titulo' => $tarefa->getTitulo(),
            'descricao' => $tarefa->getDescricao(),
            'concluida' => $tarefa->isConcluida(),
            'dataCriacao' => $tarefa->getDataCriacao()->format('Y-m-d H:i:s'),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/tarefas/{id}', name: 'tarefa_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $tarefa = $this->entityManager->getRepository(Tarefa::class)->find($id);

        if (!$tarefa) {
            return new JsonResponse(['error' => 'Tarefa não encontrada.'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($tarefa);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
