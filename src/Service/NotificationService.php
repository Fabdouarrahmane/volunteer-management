<?php

namespace App\Service;

use App\Entity\Affectation;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NotificationService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendAffectationNotification(Affectation $affectation): void
    {
        $benevole = $affectation->getBenevole();
        $evenement = $affectation->getEvenement();

        $email = (new Email())
            ->from('noreply@volunteer-management.fr')
            ->to($benevole->getEmail())
            ->subject('Nouvelle affectation — '.$evenement->getTitre())
            ->html(
                '<h2>Bonjour '.$benevole->getPrenom().' '.$benevole->getNom().',</h2>
                <p>Vous avez été affecté(e) à l\'événement suivant :</p>
                <ul>
                    <li><strong>Événement :</strong> '.$evenement->getTitre().'</li>
                    <li><strong>Date :</strong> '.$evenement->getDateEvenement()->format('d/m/Y à H:i').'</li>
                    <li><strong>Lieu :</strong> '.($evenement->getLieu() ?? 'Non précisé').'</li>
                    <li><strong>Rôle :</strong> '.$affectation->getRoleMission().'</li>
                    <li><strong>Statut :</strong> '.$affectation->getStatutAffectation().'</li>
                </ul>
                <p>Connectez-vous à la plateforme pour plus de détails.</p>'
            );

        $this->mailer->send($email);
    }
}
