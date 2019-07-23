<?php


namespace MoviePortalBundle\Form;


use MoviePortalBundle\Entity\Actor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('dateOfBirth', DateType::class, ['label' => 'Date of Birth', 'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),
                'months' => range(1, 12),
                'days' => range(1, 31)])
            ->add('placeOfBirth', TextType::class, ['label' => 'Place of Birth', 'trim' => true])
            ->add('height', IntegerType::class,['label' => 'Height',])
            ->add('save', SubmitType::class, ['label' => 'Save Actor']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Actor::class]
        );
    }


}