<?php

namespace App\Form\Inventory;

use App\Entity\Category;
use App\Form\Inventory\SubCategoryCatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryName')
            ->add('categoryDescription')
            ->add('enabled')
            ->add('subCategories', CollectionType::class, array(
              'entry_type'   => SubCategoryCatType::class,
              'allow_add'    => true,
              'allow_delete' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
