<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{

  const MEMBER = 'Role_User';
  const MANAGER = 'Role_Manager';
  const ADMIN = 'Role_Admin';
  const SUPERADMIN = 'Role_Super_Admin';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('password')
            ->add('phone')
            ->add('CreatedAt')
            ->add('UpdatedAt')
            ->add('enabled')
            ->add('restricted')
            ->add('roles', CollectionType::class, array(
              'entry_type'   => ChoiceType::class,
              'entry_options'  => array(
                'choices'  => array(
                  'Member' => self::MEMBER,
                  'Manager'     => self::MANAGER,
                  'Admin'    => self::ADMIN,
                  'Super Admin'    => self::SUPERADMIN,
                ),
                'expanded' => true,
              ),

            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
