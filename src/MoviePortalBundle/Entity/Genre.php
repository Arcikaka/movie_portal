<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\GenreRepository")
 */
class Genre
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
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;
    /**
     * @var Movie
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Movie", inversedBy="genre")
     */
    private $movies;

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


    public function addMovies(Movie $movie)
    {
        if(!$this->movies->contains($movie)) {
            $this->movies->add($movie);
        }
    }

    public function removeMovies(Movie $movie)
    {
        if($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
        }
    }

    public function getMovies() : Collection
    {
        return $this->movies;
    }
}

