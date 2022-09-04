<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\DataTransfert\UpdatePasswordData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class UpdatePasswordType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('current', PasswordType::class, [
                'label' => 'Mot de passe actuel',
            ])
            ->add('new', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les deux mot de passe doivent correspondre',
                'required' => true,
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePasswordData::class,
        ]);
    }
}
