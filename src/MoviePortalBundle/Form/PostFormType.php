<?php

namespace MoviePortalBundle\Form;


use MoviePortalBundle\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class, ['label' => 'name', 'trim' => true])
            ->add('contentHtml', TextType::class, ['label' => 'content'])
            ->add('category', EntityType::class, ['label' => 'category', 'class' => 'MoviePortalBundle\Entity\Category', 'choice_label' => 'name'])
            ->add('save', SubmitType::class, ['label' => 'Save Post']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Post::class]
        );
    }
}