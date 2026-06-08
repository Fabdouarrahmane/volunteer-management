<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class BenevoleDashboardController extends AbstractController
{
    #[Route('/benevole', name: 'app_benevole_dashboard')]
    public function index(): Response
    {
        return $this->render('benevole/dashboard.html.twig');
    }

    #[Route('/benevole/affectations', name: 'app_benevole_affectation_index')]
    #[IsGranted('ROLE_BENEVOLE')]
    public function affectations(): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        return $this->render('benevole/affectations/index.html.twig', [
            'affectations' => $benevole->getAffectations()->toArray(),
        ]);
    }
}
