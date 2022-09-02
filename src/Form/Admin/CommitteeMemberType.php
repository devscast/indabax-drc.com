<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\CommitteeMember;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class CommitteeMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('role', TextType::class, [
                'label' => 'Rôle',
            ])
            ->add('avatar_file', DropzoneType::class, [
                'label' => 'Avatar',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommitteeMember::class,
        ]);
    }
}
