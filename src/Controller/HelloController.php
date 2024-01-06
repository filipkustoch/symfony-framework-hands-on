<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HelloController extends AbstractController
{
    private array $messages = ['Hello', 'Hi', 'Bye'];

    #[Route('/{limit<\d+>?2}', name: 'app_index')]
    public function index(int $limit): Response
    {
        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => $limit
            ]
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one_message')]
    public function showOneMessage(int $id): Response
    {
        return $this->render(
            'hello/show_one_message.html.twig',
            [
                'message' => $this->getMessageById($id),
            ]
        );
    }

    private function getMessageById(int $id): string
    {
        if (array_key_exists($id - 1, $this->messages)) {
            return $this->messages[$id - 1];
        }
        throw new NotFoundHttpException('Message not found');
    }
}
