<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        dump($options); die;
        $builder
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, [
                'label' => $options['label'],
                'attr' => [
                  'class' => 'form-control btn-primary'
                ],
            ])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}

//$form = $this->createFormBuilder($article)
//    ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
//    ->add('body', TextareaType::class, array(
//        'required' => false,
//        'attr' => array('class' => 'form-control')
//    ))
//    ->add('save', SubmitType::class, array(
//        'label' => 'Create',
//        'attr' => array('class' => 'btn btn-primary mt-3')
//    ))
//    ->getForm();