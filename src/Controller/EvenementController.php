<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/evenements')]
#[IsGranted('ROLE_ADMIN')]
class EvenementController extends AbstractController
{
    #[Route('', name: 'app_evenement_index')]
    public function index(EvenementRepository $repo): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $repo->findBy(
                ['administrateur' => $this->getUser()],
                ['dateEvenement' => 'ASC']
            ),
        ]);
    }

    #[Route('/nouveau', name: 'app_evenement_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setAdministrateur($this->getUser());
            $em->persist($evenement);
            $em->flush();

            $this->addFlash('success', 'Événement créé avec succès.');

            return $this->redirectToRoute('app_evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', requirements: ['id' => '\d+'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_evenement_edit', requirements: ['id' => '\d+'])]
    public function edit(Evenement $evenement, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Événement modifié avec succès.');

            return $this->redirectToRoute('app_evenement_index');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_evenement_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Evenement $evenement, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete_evenement_'.$evenement->getId(), $request->request->get('_token'))) {
            $em->remove($evenement);
            $em->flush();
            $this->addFlash('success', 'Événement supprimé avec succès.');
        }

        return $this->redirectToRoute('app_evenement_index');
    }
}
