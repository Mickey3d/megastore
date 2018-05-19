<?php

namespace App\Form\Inventory;

use App\Entity\Status;
use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatusType extends AbstractType
{

  const SUCCESS = 'success';
  const INFO = 'info';
  const WARNING = 'warning';
  const DANGER = 'danger';


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statusName')
            ->add('statusType', ChoiceType::class, array(
              'choices'  => array(
                'Success' => self::SUCCESS,
                'Info'     => self::INFO,
                'Warning'    => self::WARNING,
                'Danger'    => self::DANGER,
              ),
              'multiple' => false,
              'expanded' => true,
            ))
            ->add('stock', EntityType::class, array(
              'class' => Stock::class,
              'choice_label' => 'stockName',
              'required'   => false,
            ))
            ->add('enabled')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
        ]);
    }
}
