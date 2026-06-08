<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/benevole/evenements')]
#[IsGranted('ROLE_BENEVOLE')]
class BenevoleEvenementController extends AbstractController
{
    #[Route('', name: 'app_benevole_evenement_index')]
    public function index(EvenementRepository $repo): Response
    {
        return $this->render('benevole/evenements/index.html.twig', [
            'evenements' => $repo->findUpcoming(),
        ]);
    }

    #[Route('/{id}', name: 'app_benevole_evenement_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EvenementRepository $repo): Response
    {
        $evenement = $repo->find($id);

        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable.');
        }

        return $this->render('benevole/evenements/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
}
