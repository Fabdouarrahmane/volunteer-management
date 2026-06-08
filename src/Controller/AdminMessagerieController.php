<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/messagerie')]
#[IsGranted('ROLE_ADMIN')]
class AdminMessagerieController extends AbstractController
{
    #[Route('', name: 'app_admin_messagerie_index')]
    public function index(MessageRepository $repo): Response
    {
        return $this->render('admin/messagerie/index.html.twig', [
            'messages' => $repo->findBy([], ['dateEnvoi' => 'DESC']),
        ]);
    }
}
