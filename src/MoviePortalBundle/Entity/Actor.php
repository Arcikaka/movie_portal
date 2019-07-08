<?php

namespace MoviePortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actor
 *
 * @ORM\Table(name="cast")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\CastRepository")
 */
class Actor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(name="surname", type="string", length=50)
     */
    private $surname;
    /**
     * @var \DateTime
     * @ORM\Column(name="date_of_birth", type="datetime")
     */
    private $dateOfBirth;
    /**
     * @var string
     * @ORM\Column(name="place_of_birth", type="string", length=100)
     */
    private $placeOfBirth;
    /**
     * @var int
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @var Movie
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Movie", mappedBy="actors")
     */
    private $movies;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string $placeOfBirth
     */
    public function setPlaceOfBirth($placeOfBirth)
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
}

