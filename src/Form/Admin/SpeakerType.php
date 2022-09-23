<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Speaker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class SpeakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data = $builder->getData();
        $edit = $data instanceof Speaker && $data->getId() !== null;

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom complet',
            ])
            ->add('job_title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('organization', TextType::class, [
                'label' => 'Organisation',
            ])
            ->add('link', UrlType::class, [
                'label' => 'Lien',
                'required' => false,
            ])
            ->add('image_file', DropzoneType::class, [
                'label' => 'Photo de profile',
                'required' => ! $edit,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Speaker::class,
        ]);
    }
}
