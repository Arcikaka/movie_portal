<?php


namespace MoviePortalBundle\Form;


use MoviePortalBundle\Entity\Actor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class, ['label' => 'Name', 'trim' => true])
            ->add('surname', TextType::class, ['label' => 'Surname', 'trim' => true])
            ->add('dateOfBirth', DateTimeType::class, ['label' => 'Date of Birth'])
            ->add('placeOfBirth', TextType::class, ['label' => 'Place of Birth', 'trim' => true])
            ->add('save', SubmitType::class, ['label' => 'Save Director']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Actor::class]
        );
    }


}