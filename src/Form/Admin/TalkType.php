<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Event;
use App\Entity\Speaker;
use App\Entity\Talk;
use App\Form\Type\AutoGrowTextareaType;
use App\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TalkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('description', AutoGrowTextareaType::class, [
                'label' => 'Description',
            ])
            ->add('schedule_at', DatePickerType::class, [
                'label' => 'Date et Heure du talk',
            ])
            ->add('speaker', EntityType::class, [
                'attr' => [
                    'is' => 'app-select-choices',
                ],
                'label' => 'Speaker',
                'class' => Speaker::class,
                'choice_label' => 'name',
            ])
            ->add('event', EntityType::class, [
                'attr' => [
                    'is' => 'app-select-choices',
                ],
                'label' => 'Évènement',
                'class' => Event::class,
                'choice_label' => 'name',
            ])
            ->add('youtube_replay_url', UrlType::class, [
                'label' => 'Url de la vidéo replay',
                'required' => false,
                'help' => 'Si le talk a été filmé veuillez précisez ici le lien de la vidéo youtube (optionnel)',
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
