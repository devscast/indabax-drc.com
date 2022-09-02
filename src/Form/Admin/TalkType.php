<?php

namespace App\Form\Admin;

use App\Entity\Event;
use App\Entity\Speaker;
use App\Entity\Talk;
use App\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TalkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('schedule_at', DatePickerType::class)
            ->add('speaker', EntityType::class, [
                'class' => Speaker::class,
                'choice_label' => 'name'
            ])
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Talk::class,
        ]);
    }
}
