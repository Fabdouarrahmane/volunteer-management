<?php

namespace App\Form;

use App\Entity\Benevole;
use App\Entity\Message;
use App\Repository\BenevoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @extends AbstractType<Message>
 */
class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUser = $options['current_user'];

        $builder
            ->add('destinataire', EntityType::class, [
                'class' => Benevole::class,
                'choice_label' => fn (Benevole $b) => $b->getPrenom().' '.$b->getNom(),
                'label' => 'Destinataire',
                'placeholder' => '-- Choisir un destinataire --',
                'query_builder' => fn (BenevoleRepository $repo) => $repo
                    ->createQueryBuilder('b')
                    ->where('b != :current')
                    ->setParameter('current', $currentUser)
                    ->orderBy('b.nom', 'ASC'),
                'constraints' => [new NotBlank(message: 'Veuillez choisir un destinataire.')],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('sujet', TextType::class, [
                'label' => 'Sujet',
                'constraints' => [new NotBlank(message: 'Le sujet est obligatoire.')],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [new NotBlank(message: 'Le message ne peut pas être vide.')],
                'attr' => ['class' => 'form-control', 'rows' => 6],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'current_user' => null,
        ]);
    }
}
