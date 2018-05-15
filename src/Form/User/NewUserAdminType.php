<?php

namespace App\Form\User;

use App\Entity\User;
use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUserAdminType extends AbstractType
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
            ->add('password', PasswordType::class, array(
              'required'   => false,
              'empty_data' => 'pass',
            ))
            ->add('email', EmailType::class, array(
              'required'   => false,
            ))
            ->add('phone', TelType::class, array(
              'required'   => false,
            ))
            ->add('enabled')
            ->add('restricted')
            ->add('team', EntityType::class, array(
              // looks for choices from this entity
              'class' => Team::class,
              // uses the User.username property as the visible option string
              'choice_label' => 'teamName',
              'required'   => false,
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
