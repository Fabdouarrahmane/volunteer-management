<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Benevole;
use App\Repository\AffectationRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_BENEVOLE')]
final class BenevoleDashboardController extends AbstractController
{
    #[Route('/benevole', name: 'app_benevole_dashboard')]
    public function index(
        AffectationRepository $affectationRepo,
        MessageRepository $messageRepo,
    ): Response {
        $benevole = $this->getUser();
        assert($benevole instanceof Benevole);

        return $this->render('benevole/dashboard.html.twig', [
            'prochaines_affectations' => $affectationRepo->findUpcomingForBenevole($benevole, 5),
            'derniers_messages' => $messageRepo->findLatestForBenevole($benevole, 5),
        ]);
    }

    #[Route('/benevole/affectations', name: 'app_benevole_affectation_index')]
    public function affectations(): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof Benevole);

        return $this->render('benevole/affectations/index.html.twig', [
            'affectations' => $benevole->getAffectations()->toArray(),
        ]);
    }
}
