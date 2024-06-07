<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu')
//            ->add('creation', null, [
//                'widget' => 'single_text',
//            ])
//            ->add('modification', null, [
//                'widget' => 'single_text',
//            ])
//            ->add('publication', EntityType::class, [
//                'class' => Publication::class,
//                'choice_label' => 'prenom',
//            ])
//            ->add('utilisateur', EntityType::class, [
//                'class' => Utilisateur::class,
//                'choice_label' => 'id',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
