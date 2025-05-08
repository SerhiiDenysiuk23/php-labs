<?php

namespace App\Form;

use App\Entity\BookIssue;
use App\Entity\BookReturn;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookReturnTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookIssue', EntityType::class, [
                'class' => BookIssue::class,
                'choice_label' => 'id',
            ])
            ->add('returnedAt', DateTimeType::class, [
                'widget' => 'single_text',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookReturn::class,
        ]);
    }
}
