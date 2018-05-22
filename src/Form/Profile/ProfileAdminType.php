<?php

namespace App\Form\Profile;

use App\Entity\Profile;
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

class ProfileAdminType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profileName')
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
            ->add('team', EntityType::class, array(
              'class' => Team::class,
              'choice_label' => 'teamName',
              'required'   => false,
            ))
            ->add('user', EntityType::class, array(
              // looks for choices from this entity
              'class' => User::class,
              // uses the User.username property as the visible option string
              'choice_label' => 'username',
              'required'   => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
