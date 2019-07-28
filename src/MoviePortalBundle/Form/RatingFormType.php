<?php


namespace MoviePortalBundle\Form;


use Doctrine\Common\Persistence\ObjectManager;
use MoviePortalBundle\Entity\Movie;
use MoviePortalBundle\Entity\Rating;
use MoviePortalBundle\Form\DataTransformer\EntityHiddenTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingFormType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('score', ChoiceType::class, ['label' => 'Rating', 'expanded' => true, 'multiple' => false, 'choices'
            => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10]])
            ->add('movies', HiddenType::class)
            ->add('save', SubmitType::class, ['label' => 'Save Rating']);

        $builder
            ->get('movies')->addModelTransformer(new EntityHiddenTransformer(
                $this->getObjectManager(),Movie::class,'id'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Rating::class]
        );
    }

}