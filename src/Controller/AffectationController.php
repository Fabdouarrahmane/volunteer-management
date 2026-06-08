<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Form\AffectationType;
use App\Repository\AffectationRepository;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/affectations')]
#[IsGranted('ROLE_ADMIN')]
class AffectationController extends AbstractController
{
    #[Route('', name: 'app_affectation_index')]
    public function index(AffectationRepository $repo): Response
    {
        return $this->render('affectation/index.html.twig', [
            'affectations' => $repo->findBy([], ['dateAffectation' => 'DESC']),
        ]);
    }

    #[Route('/nouvelle', name: 'app_affectation_new')]
    public function new(Request $request, EntityManagerInterface $em, NotificationService $notif): Response
    {
        $affectation = new Affectation();
        $affectation->setDateAffectation(new \DateTime());

        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($affectation);
            $em->flush();

            try {
                $notif->sendAffectationNotification($affectation);
                $this->addFlash('success', 'Affectation créée et notification envoyée.');
            } catch (\Exception $e) {
                $this->addFlash('warning', 'Affectation créée mais l\'email n\'a pas pu être envoyé.');
            }

            return $this->redirectToRoute('app_affectation_index');
        }

        return $this->render('affectation/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affectation_show', requirements: ['id' => '\d+'])]
    public function show(Affectation $affectation): Response
    {
        return $this->render('affectation/show.html.twig', [
            'affectation' => $affectation,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_affectation_edit', requirements: ['id' => '\d+'])]
    public function edit(Affectation $affectation, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Affectation modifiée avec succès.');

            return $this->redirectToRoute('app_affectation_index');
        }

        return $this->render('affectation/edit.html.twig', [
            'affectation' => $affectation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_affectation_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Affectation $affectation, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete_affectation_'.$affectation->getId(), $request->request->get('_token'))) {
            $em->remove($affectation);
            $em->flush();
            $this->addFlash('success', 'Affectation supprimée avec succès.');
        }

        return $this->redirectToRoute('app_affectation_index');
    }
}
