<?php

namespace App\Controller;

use App\Entity\Benevole;
use App\Form\BenevoleType;
use App\Repository\BenevoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/benevoles')]
#[IsGranted('ROLE_ADMIN')]
class AdminBenevoleController extends AbstractController
{
    #[Route('', name: 'app_admin_benevole_index')]
    public function index(BenevoleRepository $repo): Response
    {
        return $this->render('admin/benevole/index.html.twig', [
            'benevoles' => $repo->findBy([], ['nom' => 'ASC']),
        ]);
    }

    #[Route('/nouveau', name: 'app_admin_benevole_new')]
    public function new(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $benevole = new Benevole();
        $form = $this->createForm(BenevoleType::class, $benevole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            assert(is_string($plainPassword));
            $benevole->setMotDePasse($hasher->hashPassword($benevole, $plainPassword));
            $em->persist($benevole);
            $em->flush();

            $this->addFlash('success', 'Compte bénévole créé avec succès.');

            return $this->redirectToRoute('app_admin_benevole_index');
        }

        return $this->render('admin/benevole/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_benevole_show', requirements: ['id' => '\d+'])]
    public function show(Benevole $benevole): Response
    {
        return $this->render('admin/benevole/show.html.twig', [
            'benevole' => $benevole,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_admin_benevole_edit', requirements: ['id' => '\d+'])]
    public function edit(Benevole $benevole, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(BenevoleType::class, $benevole, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                assert(is_string($plainPassword));
                $benevole->setMotDePasse($hasher->hashPassword($benevole, $plainPassword));
            }
            $em->flush();
            $this->addFlash('success', 'Compte bénévole modifié avec succès.');

            return $this->redirectToRoute('app_admin_benevole_index');
        }

        return $this->render('admin/benevole/edit.html.twig', [
            'benevole' => $benevole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_admin_benevole_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Benevole $benevole, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete_benevole_'.$benevole->getId(), $request->request->get('_token'))) {
            $em->remove($benevole);
            $em->flush();
            $this->addFlash('success', 'Compte bénévole supprimé avec succès.');
        }

        return $this->redirectToRoute('app_admin_benevole_index');
    }
}
