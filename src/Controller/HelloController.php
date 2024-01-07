<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HelloController extends AbstractController
{
  private array $messages = [
    ['message' => 'Hello', 'created' => '2023/06/12'],
    ['message' => 'Hi', 'created' => '2023/04/12'],
    ['message' => 'Bye!', 'created' => '2022/05/12']
  ];

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
    try {
      $message = $this->getMessageById($id);

      return $this->render(
        'hello/show_one_message.html.twig',
        [
          'message' => $message,
        ]
      );
    } catch (NotFoundHttpException $e) {
      throw $this->createNotFoundException('Message not found', $e);
    }
  }

  private function getMessageById(int $id): array
  {
    if (array_key_exists($id - 1, $this->messages)) {
      return $this->messages[$id - 1];
    }
    throw new NotFoundHttpException('Message not found');
  }
}
