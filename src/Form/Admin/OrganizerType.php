<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Organizer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class OrganizerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data = $builder->getData();
        $edit = $data instanceof Organizer && $data->getId() !== null;

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom complet',
            ])
            ->add('role', TextType::class, [
                'label' => 'Rôle',
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
            'data_class' => Organizer::class,
        ]);
    }
}
