<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('avatar', FileType::class, [
                'label' => 'Add your avatar',
                'multiple' => false,
                'mapped' => false,
                'required' => false, 'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/webp',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Only jpeg or webp format are allowed.',
                    ]),
                ],
            ])
            /*->add(
                'roles',
                ChoiceType::class,
                [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => [
                        'Administrateur' => 'ROLE_ADMIN',
                        'Utilisateur' => 'ROLE_USER',
                    ],
                    'mapped' => true,
                    'label' => 'Privilèges',
                ]
            )*/
//            ->add('is_active')
            ->add('Save', SubmitType::class);

        // Data transformer
        /*$builder->get('roles')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($rolesArray) {
                        // transform the array to a string
                        return count($rolesArray) ? $rolesArray[0] : null;
                    },
                    function ($rolesString) {
                        // transform the string back to an array
                        return [$rolesString];
                    }
                )
            );*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
