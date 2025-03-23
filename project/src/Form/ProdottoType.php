<?php

namespace App\Form;

use App\Entity\Prodotto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProdottoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => 'Nome del prodotto',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prezzo', TextType::class, [
                'label' => 'Prezzo',
                'attr' => ['class' => 'form-control']
            ])
            ->add('descrizione', TextareaType::class, [
                'label' => 'Descrizione',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Salva',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prodotto::class,
        ]);
    }
}
