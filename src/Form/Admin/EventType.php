<?php

namespace App\Form\Admin;

use App\Entity\Event;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('event_starts_at', DatePickerType::class)
            ->add('event_ends_at', DatePickerType::class)
            ->add('registration_starts_at', DatePickerType::class)
            ->add('registration_ends_at', DatePickerType::class)
            ->add('description', TextareaType::class)
            ->add('location', TextType::class)
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
