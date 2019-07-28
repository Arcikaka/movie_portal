<?php


namespace MoviePortalBundle\Form;


use MoviePortalBundle\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class, ['label' => 'Name', 'trim' => true])
            ->add('save', SubmitType::class, ['label' => 'Save Genre']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Genre::class]
        );
    }


}