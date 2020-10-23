<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => 9]
            ])
            ->add('image', FileType::class, [
                'label' => 'Main image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload jpeg or png',
                    ]),
                ],
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'required' => false,
                'entry_options' => [
                    'label' => false,
                ],
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ])
            ->add(
                'category',
                EntityType::class,
                [
                    'choice_label' => 'name',
                    'label' => 'Trick category',
                    'class' => TrickCategory::class,
                    'multiple' => true,
                ]
            )
//            ->add('comments', CollectionType::class, [
//                'entry_type' => CommentType::class,
//                'required' => false,
//                'entry_options' => [
//                    'label' => 'Comment',
//                ],
//                'label' => false,
//                'by_reference' => false,
//                'allow_add' => false,
//                'allow_delete' => true,
//                'prototype' => true,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Trick::class,
                'validation_groups' => ['new_trick'],
            ]
        );
    }
}
