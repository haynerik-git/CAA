<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('nbCol',TextType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'class' => 'slider-range-max-column'
                ]
            ])
            ->add('nbRow')
            ->add('background')
            ->add('font')
            ->add('filename')
            ->add('backgroundCell')
            ->add('backgroundTab')
            ->add('colorDescription')
            ->add('border')
            ->add('autoSpeak')
            ->add('displayOrder')
            ->add('backgroundCard')
            ->add('visible')
            ->add('addHasWord')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'pseudo',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
