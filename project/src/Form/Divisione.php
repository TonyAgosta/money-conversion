<?php

namespace App\Form;

use App\Validator\FormatConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Positive;

class Divisione extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dividendo', TextType::class, [
                'attr' => ['class' => 'tinymce', 'placeholder' => 'Es: 5p 10s 3d'],
                'constraints' => [
                    new FormatConstraint(),
                ],
                'label' => ' ',
                'required' => true,
            ])
            ->add('divisore', IntegerType::class, [
                'attr' => ['class' => 'tinymce'],
                'constraints' => [
                    new Positive(['message' => 'Il divisore deve essere maggiore di 0']),
                ],
                'label' => ' ',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Calcola']);
    }
}
