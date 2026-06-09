<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\DisponibiliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/disponibilites', name: 'app_admin_disponibilite_')]
#[IsGranted('ROLE_ADMIN')]
class AdminDisponibiliteController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(DisponibiliteRepository $repo): Response
    {
        return $this->render('admin/disponibilite/index.html.twig', [
            'disponibilites' => $repo->findAllOrderedByDate(),
        ]);
    }
}
