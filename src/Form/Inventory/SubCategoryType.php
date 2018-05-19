<?php

namespace App\Form\Inventory;

use App\Entity\SubCategory;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subEntityName')
            ->add('subCategoryDescription')
            ->add('category', EntityType::class, array(
              'class' => Category::class,
              'choice_label' => 'categoryName',
              'required'   => true,
            ))
            ->add('enabled')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class,
        ]);
    }
}
