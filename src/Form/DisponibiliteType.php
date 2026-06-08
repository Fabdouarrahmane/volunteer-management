<?php

namespace App\Form;

use App\Entity\Disponibilite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @extends AbstractType<Disponibilite>
 */
class DisponibiliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDisponibilite', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'constraints' => [new NotBlank(message: 'La date est obligatoire.')],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('heureDebut', TimeType::class, [
                'label' => 'Heure de début',
                'widget' => 'single_text',
                'constraints' => [new NotBlank(message: "L'heure de début est obligatoire.")],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('heureFin', TimeType::class, [
                'label' => 'Heure de fin',
                'widget' => 'single_text',
                'constraints' => [new NotBlank(message: "L'heure de fin est obligatoire.")],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('statutDisponibilite', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Disponible' => 'disponible',
                    'Indisponible' => 'indisponible',
                ],
                'attr' => ['class' => 'form-select'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibilite::class,
        ]);
    }
}
