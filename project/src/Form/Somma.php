<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Somma extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addendo_1', TextType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => ' ',
                'required' => true,
            ])
            ->add('addendo_2', TextType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => ' ',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Calcola Somma']);
    }
}
