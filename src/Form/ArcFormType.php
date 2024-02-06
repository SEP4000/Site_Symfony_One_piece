<?php

namespace App\Form;

use App\Entity\Arc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArcFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_a', options:[
                'label' => 'Nom de l\'arc'
            ])
            ->add('nbr_chap', options:[
                'label' => 'Numéro du premier et dernier chapitre du manga de l\'arc'
            ])
            ->add('nbr_anime' , options:[
                'label' => 'Numéro du premier et dernier épisode de l\'anime de l\'arc'
            ])
            ->add('desription', options:[
                'label' => 'Description de l\'Arc'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Arc::class,
        ]);
    }
}
