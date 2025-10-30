<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Sentences;
use App\Entity\User;
use App\Entity\Word;
use App\Entity\WordConfiguration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('filename')
            ->add('display_order')
            ->add('arasaac')
            ->add('categoriesWord', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('sentences', EntityType::class, [
                'class' => Sentences::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('nextCategories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('type', EntityType::class, [
                'class' => WordConfiguration::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Word::class,
        ]);
    }
}
