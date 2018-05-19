<?php

namespace App\Form\Inventory;

use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stockName')
            ->add('stockDescription')
            ->add('location')
            ->add('definedAs')
            ->add('definedAs', ChoiceType::class, array(
              'choices'  => array(
                'main-stock' => Stock::MAINSTOCK,
                'outer-stock'     => Stock::OUTER,
                'donation-stock'    => Stock::DONATION,
                'saled-stock'    => Stock::SALED,
                'lost-stock'     => Stock::LOST,
                'broken-stock'    => Stock::BROKEN,
                'trash-stock'    => Stock::TRASH,
              ),
              'multiple' => false,
              'expanded' => false,
              'required'   => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
