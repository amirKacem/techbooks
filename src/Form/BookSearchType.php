<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\BookSearch;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('by_keyword',TextType::class,
                [   'required'=>false,
                    'attr'=> [
                        'placeholder'=>'Search By Keyword',

                    ] ,
                    'label'=>'Search By Keyword'
                ]
            )
            ->add('by_category',EntityType::class,
                [
                    'class'=> Category::class,
                    'required' => false,
                    'placeholder' => 'All Categories',
                    'choice_label'=> 'name',
                    'attr'=> [
                        'class'=>'form-control'
                    ],
                    'label'=>'Search By Category'
                ]
            )
            ->add('by_author',EntityType::class,
            [
                'class'=> Author::class,
                'required' => false,
                'placeholder' => 'All Authors',
                'choice_label'=> 'fullname',
                'attr'=> [
                    'class'=>'form-control'
                ],
                'label'=>'Search By Author'
            ]
        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookSearch::class,
            'method'=>'get',
            'csrf_protection'=>false
          
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
