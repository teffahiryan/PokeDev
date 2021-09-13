<?php

namespace App\Form;

use App\Entity\Bot;
use App\Entity\User;
use App\Entity\Attack;
use App\Entity\Equipe;
use App\Entity\Pokemon;
use App\Entity\CatchPokemon;
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
            ->add('catchPokemon', EntityType::class, [
                'class' => CatchPokemon::class,
                'label' => 'Pokemon',
                'multiple' => 'true',
                'choice_label' => 'id',
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
