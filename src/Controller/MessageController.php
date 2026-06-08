<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/benevole/messages')]
#[IsGranted('ROLE_BENEVOLE')]
class MessageController extends AbstractController
{
    #[Route('', name: 'app_message_index')]
    public function index(MessageRepository $repo): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        return $this->render('message/index.html.twig', [
            'messagesRecus' => $repo->findBy(
                ['destinataire' => $benevole],
                ['dateEnvoi' => 'DESC']
            ),
            'messagesEnvoyes' => $repo->findBy(
                ['expediteur' => $benevole],
                ['dateEnvoi' => 'DESC']
            ),
        ]);
    }

    #[Route('/nouveau', name: 'app_message_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message, [
            'current_user' => $benevole,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setExpediteur($benevole);
            $message->setDateEnvoi(new \DateTime());
            $em->persist($message);
            $em->flush();

            $this->addFlash('success', 'Message envoyé avec succès.');

            return $this->redirectToRoute('app_message_index');
        }

        return $this->render('message/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_show', requirements: ['id' => '\d+'])]
    public function show(Message $message): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        if ($message->getDestinataire() !== $benevole && $message->getExpediteur() !== $benevole) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_message_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Message $message, Request $request, EntityManagerInterface $em): Response
    {
        $benevole = $this->getUser();
        assert($benevole instanceof \App\Entity\Benevole);

        if ($message->getExpediteur() !== $benevole) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete_message_'.$message->getId(), $request->request->get('_token'))) {
            $em->remove($message);
            $em->flush();
            $this->addFlash('success', 'Message supprimé.');
        }

        return $this->redirectToRoute('app_message_index');
    }
}
