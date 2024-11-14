<?php

namespace App\Form;

use App\Entity\Editeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AjoutEditeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('editeur', TextType::class, [
                'label' => "Nom de l'editeur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom de l'éditeur",
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => "Adresse de l'editeur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir l'adresse de l'éditeur",
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => "Contact(s) de l'éditeur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le(s) contact(s) de l'éditeur",
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Email de l'auteur",
                'required' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir l'email de l'auteur",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Editeur::class,
        ]);
    }
}
