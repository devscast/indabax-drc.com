<?php

namespace App\Form\Admin;

use App\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('link', UrlType::class, [
                'label' => 'Lien'
            ])
            ->add('image_file', DropzoneType::class, [
                'label' => 'logo du sponsor'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}
