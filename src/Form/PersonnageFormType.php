<?php

namespace App\Form;

use App\Entity\Personnage;
use App\Entity\Arc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_p', options:[
                'label' => 'Nom du personnage'
            ])
            ->add('prenom_p', options:[
                'label' => 'Prénom du personnage'
            ])
            ->add('age', options:[
                'label' => 'Age du personnage'
            ])
            ->add('apparition_manga', options:[
                'label' => 'Numéro du chapitre de l\'apparition du personnage dans le manga'
            ])
            ->add('apparition_anime', options:[
                'label' => 'Numéro de l\'episode de l\'apparition du personnage dans l\'anime'
            ])
            ->add('description', options:[
                'label' => 'Description du personnage'
            ])
            ->add('arc', EntityType::class, [
                'class' => Arc :: class,
                'choice_label' => 'nom_a',
                'label' => 'L\'arc dans lequel le personnage est apparu'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}
