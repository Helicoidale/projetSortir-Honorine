<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('mail')

            ->add('pseudo')

            ->add('oldPassword', PasswordType::class, array(

               'mapped' => false,
                'label'=>'mot de passe actuel'

                ))

            ->add('plainPassword', RepeatedType::class, array(

               'type' => PasswordType::class,

                'invalid_message' => 'Les deux mots de passe doivent être identiques',

                    'first_options'  => array('label' => 'nouveau mot de passe'),
                    'second_options' => array('label' => 'le repeter'),

                   )

            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
