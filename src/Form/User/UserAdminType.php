<?php

namespace App\Form\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminType extends AbstractType
{

  const MEMBER = 'ROLE_USER';
  const MANAGER = 'ROLE_MANAGER';
  const ADMIN = 'ROLE_ADMIN';
  const SUPERADMIN = 'ROLE_SUPER_ADMIN';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('email', EmailType::class, array(
              'required'   => false,
            ))
            ->add('phone', TelType::class, array(
              'required'   => false,
            ))
            ->add('enabled')
            ->add('restricted')
            ->add('team', CollectionType::class, array(
              'entry_type' => ChoiceType::class, array(
              'multiple' => false,
              'expanded' => true,
            ),
          ))
            ->add('roles', ChoiceType::class, array(
              'choices'  => array(
                'Member' => self::MEMBER,
                'Manager'     => self::MANAGER,
                'Admin'    => self::ADMIN,
                'Super Admin'    => self::SUPERADMIN,
              ),
              'multiple' => true,
              'expanded' => true,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
