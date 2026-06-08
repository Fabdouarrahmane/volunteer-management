<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Benevole;
use App\Form\ProfilAdminType;
use App\Form\ProfilBenevoleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profil', name: 'app_profil')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ProfilController extends AbstractController
{
    #[Route('', name: '')]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
    ): Response {
        $user = $this->getUser();

        if ($user instanceof Administrateur) {
            $form = $this->createForm(ProfilAdminType::class, $user);
        } else {
            assert($user instanceof Benevole);
            $form = $this->createForm(ProfilBenevoleType::class, $user);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Changement de mot de passe (champ commun aux deux forms)
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                assert(is_string($plainPassword));
                if ($user instanceof Administrateur) {
                    $user->setMotDePasse($hasher->hashPassword($user, $plainPassword));
                } else {
                    $user->setMotDePasse($hasher->hashPassword($user, $plainPassword));
                }
            }

            $em->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
}
