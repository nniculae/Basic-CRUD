<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    // TODO: add country
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, ['label' => 'Naam en acthternaam'])
            ->add('adres')
            ->add('postCode')
            ->add('location')
            ->add('country', EntityType::class, [
//                'choice_label' => 'name',
//                'choice_value' => 'name',
                'placeholder' => 'Choose a country',
                'class' => Country::class,
                'query_builder' => function (CountryRepository $countryRepository) {
                    return $countryRepository->createAlphabeticalQueryBuider();
                },
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('isVerified', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
