<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AjoutFournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom du fournisseur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom du fournisseur",
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => "Adresse du fournisseur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir l'adresse du fournisseur",
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => "Contact(s) du fournisseur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le(s) contact(s) du fournisseur",
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Email du fournisseur",
                'required' => false,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir l'email du fournisseur",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
