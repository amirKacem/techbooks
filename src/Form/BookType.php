<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use App\Entity\Author;
use Vich\UploaderBundle\Form\Type\VichFileType;


class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('Isbn',IntegerType::class)
            ->add('bookImage',VichFileType::class,
                 [
                     'attr' => ['class' => 'form-control'],
                     'label' => 'Image (jpg,png,jpeg...)',
                     'required' => false,
                     'allow_delete' => false,
                     'asset_helper' => true,
                 ]
            )
            ->add('bookFile',VichFileType::class,
            
                [
                    'attr' => ['class' => 'form-control'],
                    'label'=>'file (pdf format)',
                    'required' => false,
                    'allow_delete' => false,
                    'asset_helper' => true,
                ]
            )
            ->add('description')
            ->add('length')
            ->add('topcis')
            ->add('category',EntityType::class,
                [
                    'class'=> Category::class,
                    'choice_label'=> 'name'
                ]
            )
            ->add('author',EntityType::class,
                    [
                        'class'=> Author::class,
                        'choice_label' => 'fullname',
                    ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
