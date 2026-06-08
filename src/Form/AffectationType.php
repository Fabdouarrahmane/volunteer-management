<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Benevole;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @extends AbstractType<Affectation>
 */
class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('benevole', EntityType::class, [
                'class' => Benevole::class,
                'choice_label' => fn (Benevole $b) => $b->getPrenom().' '.$b->getNom(),
                'label' => 'Bénévole',
                'placeholder' => '-- Choisir un bénévole --',
                'constraints' => [new NotBlank(message: 'Veuillez choisir un bénévole.')],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => fn (Evenement $e) => $e->getTitre().' ('.$e->getDateEvenement()->format('d/m/Y').')',
                'label' => 'Événement',
                'placeholder' => '-- Choisir un événement --',
                'constraints' => [new NotBlank(message: 'Veuillez choisir un événement.')],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('roleMission', TextType::class, [
                'label' => 'Rôle / Mission',
                'constraints' => [new NotBlank(message: 'Le rôle est obligatoire.')],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Accueil, Logistique...'],
            ])
            ->add('statutAffectation', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Confirmée' => 'confirmee',
                    'En attente' => 'en_attente',
                    'Annulée' => 'annulee',
                ],
                'attr' => ['class' => 'form-select'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
