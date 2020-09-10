<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('description', TextType::class)
            ->add(
                'image',
                FileType::class,
                [
                    'required' => false,
                    'label' => 'Image principal',
                    'mapped' => false,
                    'constraints' => [
                        new File(
                            [
                                'mimeTypes' => [
                                    'image/png',
                                    'image/jpg',
                                    'image/jpeg',
                                ],
                                'mimeTypesMessage' => 'Le fichier doit etre de type jpeg ou png',
                            ]
                        ),
                    ],
                ]
            )
            ->add('images', FileType::class, [
                'label' => 'Ajouter des images à la gallerie',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'required' => false,
                'entry_options' => [
                    'label' => 'Video url',
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
                    'label' => 'Catégorie',
                    'class' => TrickCategory::class,
                    'multiple' => true,
                ]
            )
            ->add('comments', CollectionType::class, [
                'entry_type' => CommentType::class,
                'required' => false,
                'entry_options' => [
                    'label' => 'Comment',
                ],
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Trick::class,
            ]
        );
    }
}
