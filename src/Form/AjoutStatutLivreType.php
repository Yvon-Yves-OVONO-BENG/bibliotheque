<?php

namespace App\Form;

use App\Entity\StatutLivre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutStatutLivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statutLivre', TextType::class, [
                'label' => "Nom du statut livre",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom du statut livre",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatutLivre::class,
        ]);
    }
}
