<?php

namespace App\Form\Profile;

use App\Entity\Profile;
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

class SimpleProfileType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profileName', TextType::class)
            ->add('firstName', TextType::class, array(
              'required'   => false,
            ))
            ->add('lastName', TextType::class, array(
              'required'   => false,
            ))
            ->add('email', EmailType::class, array(
              'required'   => false,
            ))
            ->add('phone', TelType::class, array(
              'required'   => false,
            ))
            ->add('enabled', TextType::class, array(
              'required'   => false,
            ))
            ->add('team', EntityType::class, array(
              'class' => Team::class,
              'choice_label' => 'teamName',
              'required'   => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
            'allow_delete' => true,
        ]);
    }

    public function getName()
    {
        return 'simpleProfile';
    }
}
