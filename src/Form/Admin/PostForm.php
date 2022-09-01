<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Post;
use App\Form\Type\AutoGrowTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

/**
 * class PostForm.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data = $builder->getData();
        $edit = $data instanceof Post && $data->getId() !== null;

        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('content', AutoGrowTextareaType::class, [
                'label' => 'Contenu',
                'help' => 'ce champ supporte la syntaxe markdown',
            ])
            ->add('thumbnail_file', DropzoneType::class, [
                'required' => ! $edit,
                'label' => 'Photo de couverture',
            ])
            ->add('is_online', CheckboxType::class, [
                'label' => 'article en ligne ?',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
