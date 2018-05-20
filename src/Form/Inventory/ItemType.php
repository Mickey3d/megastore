<?php

namespace App\Form\Inventory;

use App\Entity\Item;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Form\Inventory\SubItemItemType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{

    private $em;

    /**
    *
    * @param EntityManagerInterface $em
    */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemRef')
            ->add('itemName')
            ->add('addedAt', DateType::class, array(
              'widget' => 'single_text',
              'required' => false,
            ))
            ->add('subItems', CollectionType::class, array(
              'entry_type'   => SubItemItemType::class,
              'allow_add'    => true,
              'allow_delete' => true
            ))
            ->add('enabled');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Category $category = null) {
        // 4. Add the province element
        $form->add('category', EntityType::class, array(
            'required' => false,
            'data' => $category,
            'placeholder' => 'Select a Category...',
            'class' => Category::class,
            'choice_label' => 'categoryName',
        ));

        // SubCategories empty, unless there is a selected Category (Edit View)
        $subCategories = array();

        // If there is a category stored in the Item entity, load the subCategories of it
        if ($category) {
            // Fetch subCategories of the Item if there's a selected category
            $repoSubCategories = $this->em->getRepository(SubCategory::class);

            $subCategories = $repoSubCategories->createQueryBuilder("q")
                ->where("q.category = :categoryid")
                ->setParameter("categoryid", $category->getId())
                ->getQuery()
                ->getResult();
        }

        // Add the SubCategories field with the properly data
        $form->add('subCategory', EntityType::class, array(
            'required' => false,
            'placeholder' => 'Select a Category first ...',
            'class' => SubCategory::class,
            'choice_label' => 'subEntityName',
            'choices' => $subCategories
        ));
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected Category and convert it into an Entity
        $category = $this->em->getRepository(Category::class)->find($data['category']);

        $this->addElements($form, $category);
    }

    function onPreSetData(FormEvent $event) {
        $item = $event->getData();
        $form = $event->getForm();

        // When you create a new item, the Category is always empty
        $category = $item->getCategory() ? $item->getCategory() : null;

        $this->addElements($form, $category);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
