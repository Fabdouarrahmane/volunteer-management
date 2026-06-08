<?php

namespace App\Form;

use App\Entity\Benevole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @extends AbstractType<Benevole>
 */
class BenevoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'];

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'constraints' => [new NotBlank(message: 'Le nom est obligatoire.')],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [new NotBlank(message: 'Le prénom est obligatoire.')],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(message: "L'email est obligatoire."),
                    new Email(message: "L'email n'est pas valide."),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'constraints' => [new NotBlank(message: 'Le téléphone est obligatoire.')],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('competences', TextareaType::class, [
                'label' => 'Compétences',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 3],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => !$isEdit,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['class' => 'form-control'],
                    'constraints' => $isEdit ? [] : [
                        new NotBlank(message: 'Le mot de passe est obligatoire.'),
                        new Length(min: 6, minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.'),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => ['class' => 'form-control'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Benevole::class,
            'is_edit' => false,
        ]);
    }
}
