<?php

namespace App\Controller;

use App\Entity\Disponibilite;
use App\Form\DisponibiliteType;
use App\Repository\DisponibiliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/benevole/disponibilites')]
#[IsGranted('ROLE_BENEVOLE')]
class DisponibiliteController extends AbstractController
{
    #[Route('', name: 'app_disponibilite_index')]
    public function index(DisponibiliteRepository $repo): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        return $this->render('disponibilite/index.html.twig', [
            'disponibilites' => $repo->findBy(
                ['benevole' => $benevole],
                ['dateDisponibilite' => 'ASC']
            ),
        ]);
    }

    #[Route('/nouvelle', name: 'app_disponibilite_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $disponibilite = new Disponibilite();
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $benevole = $this->getUser();
            assert($benevole instanceof \App\Entity\Benevole);

            $disponibilite->setBenevole($benevole);
            $em->persist($disponibilite);
            $em->flush();

            $this->addFlash('success', 'Disponibilité ajoutée avec succès.');

            return $this->redirectToRoute('app_disponibilite_index');
        }

        return $this->render('disponibilite/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_disponibilite_edit', requirements: ['id' => '\d+'])]
    public function edit(Disponibilite $disponibilite, Request $request, EntityManagerInterface $em): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        if ($disponibilite->getBenevole() !== $benevole) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Disponibilité modifiée avec succès.');

            return $this->redirectToRoute('app_disponibilite_index');
        }

        return $this->render('disponibilite/edit.html.twig', [
            'disponibilite' => $disponibilite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_disponibilite_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Disponibilite $disponibilite, Request $request, EntityManagerInterface $em): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        if ($disponibilite->getBenevole() !== $benevole) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete_disponibilite_'.$disponibilite->getId(), $request->request->get('_token'))) {
            $em->remove($disponibilite);
            $em->flush();
            $this->addFlash('success', 'Disponibilité supprimée avec succès.');
        }

        return $this->redirectToRoute('app_disponibilite_index');
    }
}
