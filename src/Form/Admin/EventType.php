<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Event;
use App\Form\Type\AutoGrowTextareaType;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'help' => 'par exemple : Édition 2022 - theme...',
            ])
            ->add('event_starts_at', DatePickerType::class, [
                'label' => 'Date de début',
            ])
            ->add('event_ends_at', DatePickerType::class, [
                'label' => 'Date de fin',
            ])
            ->add('registration_starts_at', DatePickerType::class, [
                'label' => "Date de début d'inscription",
            ])
            ->add('registration_ends_at', DatePickerType::class, [
                'label' => "Date de fin d'inscription",
            ])
            ->add('description', AutoGrowTextareaType::class, [
                'label' => 'Description',
            ])
            ->add('location', TextType::class, [
                'label' => "Lieu de l'évènement",
            ])
            ->add('google_form_link', UrlType::class, [
                'label' => 'Lien formulaire Google',
                'required' => false,
                'help' => "Lien à utiliser pour l'inscription",
            ])
            ->add('google_map_link', NumberType::class, [
                'label' => 'Lien google map',
                'required' => false,
                'help' => 'Lien de l\'iframe de la carte google (optionnel)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
