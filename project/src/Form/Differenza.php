<?php

namespace App\Form;

use App\Validator\FormatConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Differenza extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minuendo', TextType::class, [
                'attr' => ['class' => 'tinymce', 'placeholder' => 'Es: 5p 10s 3d'],
                'constraints' => [
                    new FormatConstraint(),
                ],
                'label' => ' ',
                'required' => true,
            ])
            ->add('sottraendo', TextType::class, [
                'attr' => ['class' => 'tinymce', 'placeholder' => 'Es: 5p 10s 3d'],
                'constraints' => [
                    new FormatConstraint(),
                ],
                'label' => ' ',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Calcola']);
    }
}
