<?php

namespace App\Controller;

use App\Repository\AffectationRepository;
use App\Repository\BenevoleRepository;
use App\Repository\EvenementRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractController
{
    #[Route('', name: 'app_admin_dashboard')]
    public function index(
        BenevoleRepository $benevoleRepo,
        EvenementRepository $evenementRepo,
        AffectationRepository $affectationRepo,
        MessageRepository $messageRepo,
    ): Response {
        $admin = $this->getUser();
        assert($admin instanceof \App\Entity\Administrateur);

        return $this->render('admin/dashboard.html.twig', [
            'nbBenevoles' => $benevoleRepo->count([]),
            'nbEvenementsAVenir' => $evenementRepo->countUpcoming(),
            'nbAffectations' => $affectationRepo->count([]),
            'derniersMessages' => $messageRepo->findLatest(5),
            'prochainEvenements' => $evenementRepo->findUpcoming(3),
        ]);
    }
}
