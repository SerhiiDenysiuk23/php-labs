<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\BookIssue;
use App\Entity\BookReturn;
use App\Entity\Reader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookIssueTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'id',
            ])
            ->add('reader', EntityType::class, [
                'class' => Reader::class,
                'choice_label' => 'id',
            ])
            ->add('issuedAt', DateTimeType::class, [
                'widget' => 'single_text',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookIssue::class,
        ]);
    }
}
