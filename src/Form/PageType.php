<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
            ->add('nbCol',HiddenType::class, [
                'attr' => [
                    'class' => 'slider-range-max-column'
                ]
            ])
            ->add('nbRow', HiddenType::class)
            ->add('background',ColorType::class, [
                'attr' => [
                    'onchange' => "myFunction_setAjax('--background', this.value)" ,
                    ]
            ])
            ->add('font')
            ->add('filename')
            ->add('backgroundCell',ColorType::class)
            ->add('backgroundTab')
            ->add('colorDescription',ColorType::class)
            ->add('border',ColorType::class)
            ->add('autoSpeak')
            ->add('displayOrder')
            ->add('backgroundCard',ColorType::class)
            ->add('visible', CheckboxType::class, [
                'attr' => [
                    'onclick' => "myFunction_setAjax('--visible', this.checked)" ,
                    'class' => 'switch'
                ],
                'required' => false
            ])
            ->add('addHasWord', CheckboxType::class, [
                'attr' => [
                    'onclick' => "myFunction_setAjax('--addHasWord', this.checked)" ,
                    'class' => 'switch'
                ],
                'required' => false
            ])
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
