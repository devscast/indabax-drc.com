<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Pricing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * class PricingType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PricingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', MoneyType::class, [
                'label' => 'Prix pour étudiants',
                'required' => false,
                'currency' => 'USD',
            ])
            ->add('academic', MoneyType::class, [
                'label' => 'Prix pour académiques',
                'currency' => 'USD',
            ])
            ->add('professional', MoneyType::class, [
                'label' => 'Prix pour professionnels',
                'currency' => 'USD',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pricing::class,
        ]);
    }
}
