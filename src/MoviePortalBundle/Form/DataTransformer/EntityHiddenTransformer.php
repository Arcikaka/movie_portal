<?php


namespace MoviePortalBundle\Form\DataTransformer;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityHiddenTransformer implements DataTransformerInterface
{

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * EntityHiddenType constructor.
     *
     * @param ObjectManager $objectManager
     * @param string $className
     * @param string $primaryKey
     */
    public function __construct(ObjectManager $objectManager, $className, $primaryKey)
    {
        $this->objectManager = $objectManager;
        $this->className = $className;
        $this->primaryKey = $primaryKey;
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Transforms an object (entity) to a string (number).
     *
     * @param object|null $entity
     *
     * @return string
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return '';
        }

        $method = 'get' . ucfirst($this->getPrimaryKey());

        return $entity->$method();
    }

    /**
     * Transforms a string (number) to an object (entity).
     *
     * @param string $identifier
     *
     * @return object|null
     * @throws TransformationFailedException if object (entity) is not found.
     */
    public function reverseTransform($identifier)
    {
        if (!$identifier) {
            return null;
        }

        $entity = $this->getObjectManager()
            ->getRepository($this->getClassName())
            ->find($identifier);

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'An entity with ID "%s" does not exist!',
                $identifier
            ));
        }

        return $entity;
    }
}