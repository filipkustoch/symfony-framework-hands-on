<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HelloController
{
    private array $messages = ['Hello', 'Hi', 'Bye'];

    #[Route('/{limit<\d+>?2}', name: 'app_index')]
    public function index(int $limit): Response
    {
        return new Response(
            implode(',', array_slice($this->messages, 0, $limit, ))
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one_message')]
    public function showOneMessage(int $id): Response
    {
        $message = $this->getMessageById($id);

        $responseData = json_encode(['message' => $message]);

        return new Response($responseData);
    }

    private function getMessageById(int $id): string
    {
        if (array_key_exists($id - 1, $this->messages)) {
            return $this->messages[$id - 1];
        }
        throw new NotFoundHttpException('Message not found');
    }
}
