<?php

namespace MoviePortalBundle\Form;

use MoviePortalBundle\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('title', TextType::class, ['label' => 'Title', 'trim' => true])
            ->add('director', EntityType::class, ['label' => 'Directors', 'class' => 'MoviePortalBundle\Entity\Director', 'choice_label' => 'surname', 'multiple' => true, 'expanded' => true])
            ->add('writers', EntityType::class, ['class' => 'MoviePortalBundle\Entity\Writers', 'label' => 'Writers', 'choice_label'=> 'surname', 'expanded' => true, 'multiple => true'])
            ->add('actors', EntityType::class, ['class' => 'MoviePortalBundle\Entity\Actor', 'label' => 'Actors', 'choice_label' => 'surname', 'expanded' => true, 'multiple' => true])
            ->add('genre', EntityType::class, ['class' => 'MoviePortalBundle\Entity\Genre', 'label' => 'Genre', 'choice_label' => 'name', 'expanded' => true, 'multiple' => true])
            ->add('releaseDate', DateTimeType::class, ['label' => 'Release Date'])
            ->add('length', IntegerType::class, ['label' => 'Length'])
            ->add('boxOffice', IntegerType::class, ['label' => 'Box Office'])
            ->add('poster', FileType::class, ['label' => 'Poster PNG', 'mapped' => false, 'required' => false, 'constraints' => ['maxSize' => '4096kb',
                'mimeTypes' => 'application/png','mimeTypeMessage' => 'Please upload a valid PNG file']])
            ->add('save', SubmitType::class, ['label' => 'Save Movie']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Movie::class]
        );
    }

}