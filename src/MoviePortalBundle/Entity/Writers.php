<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Writers
 *
 * @ORM\Table(name="writers")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\WritersRepository")
 */
class Writers
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
     * @ORM\Column(name="name", type="string", length=40)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(name="surname", type="string", length=50)
     */
    private $surname;
    /**
     * @var Movie
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Movie", inversedBy="writers")
     */
    private $movies;
    //todo seter and geter for movies

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }


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
}

