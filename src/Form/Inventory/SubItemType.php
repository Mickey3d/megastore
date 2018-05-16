<?php

namespace App\Form\Inventory;

use App\Entity\SubItem;
use App\Entity\Item;
use App\Entity\Status;
use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subItemRef')
            ->add('price', MoneyType::class, array(
              'required' => false,
            ))
            ->add('owner', TextType::class, array(
              'required' => false,
            ))
            ->add('comment')
            ->add('enabled')
            ->add('inStore')
            ->add('reserved')
            ->add('item', EntityType::class, array(
              // looks for choices from this entity
              'class' => Item::class,
              // uses the User.username property as the visible option string
              'choice_label' => 'itemName',
              'required'   => true,
            ))
            ->add('status', EntityType::class, array(
              // looks for choices from this entity
              'class' => Status::class,
              // uses the User.username property as the visible option string
              'choice_label' => 'statusName',
              'required'   => false,
            ))
            ->add('stock', EntityType::class, array(
              // looks for choices from this entity
              'class' => Stock::class,
              // uses the User.username property as the visible option string
              'choice_label' => 'stockName',
              'required'   => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubItem::class,
        ]);
    }
}
