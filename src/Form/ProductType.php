<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        dump($options); die;
        $builder
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('category', EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name',
                ])
            ->add('save', SubmitType::class, [
                'label' => $options['label'],
                'attr' => [
                    'class' => 'form-control btn-primary'
                ],
            ])
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}


