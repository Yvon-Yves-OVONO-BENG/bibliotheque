<?php

namespace App\Form;

use App\Entity\GenreLitteraire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutGenreLitteraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genreLitteraire', TextType::class, [
                'label' => "Nom du genre littéraire",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom du genre littéraire",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GenreLitteraire::class,
        ]);
    }
}
