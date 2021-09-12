<?php

namespace App\Form;

use App\Entity\Bot;
use App\Entity\User;
use App\Entity\Attack;
use App\Entity\Equipe;
use App\Entity\Pokemon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trainer', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('botTrainer', EntityType::class, [
                'class' => Bot::class,
                'choice_label' => 'name',
            ])
            ->add('pokemonId', EntityType::class, [
                'class' => Pokemon::class,
                'label' => 'Pokemon',
                'multiple' => 'true',
                'choice_label' => 'name',
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
