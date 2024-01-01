<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HelloController
{
    private array $messages = ['Hello', 'Hi', 'Bye'];

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return new JsonResponse($this->messages);
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one_message')]
    public function showOneMessage(int $id): Response
    {
        $message = $this->getMessageById($id);
        return new JsonResponse(['message' => $message]);
    }

    private function getMessageById(int $id): string
    {
        if (array_key_exists($id - 1, $this->messages)) {
            return $this->messages[$id - 1];
        }
        throw new NotFoundHttpException('Message not found');
    }
}
