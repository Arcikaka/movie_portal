<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\MovieRepository")
 */
class Movie
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
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var Director
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Director", mappedBy="movies")
     *
     */
    private $director;

    /**
     * @var Writers
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Writers", mappedBy="movies")
     */
    private $writers;

    /**
     * @var Actor
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Actor", mappedBy="movies")
     *
     */
    private $actors;

    /**
     * @var Genre
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Genre", mappedBy="movies")
     *
     */
    private $genre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="datetime")
     */
    private $releaseDate;

    /**
     * @var Rating
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Rating", mappedBy="movies")
     *
     */
    private $rating;

    /**
     * @var int
     *
     * @ORM\Column(name="length", type="integer")
     */
    private $length;

    /**
     * @var int
     *
     * @ORM\Column(name="boxOffice", type="integer")
     */
    private $boxOffice;
    /**
     * @var string
     * @ORM\Column(name="poster", type="string")
     */
    private $poster;

    public function __construct()
    {
        $this->director = new ArrayCollection();
        $this->writers = new ArrayCollection();
        $this->rating = new ArrayCollection();
        $this->genre = new ArrayCollection();
        $this->actors = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Movie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }


    /**
     * Set length
     *
     * @param integer $length
     *
     * @return Movie
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set boxOffice
     *
     * @param integer $boxOffice
     *
     * @return Movie
     */
    public function setBoxOffice($boxOffice)
    {
        $this->boxOffice = $boxOffice;

        return $this;
    }

    /**
     * Get boxOffice
     *
     * @return int
     */
    public function getBoxOffice()
    {
        return $this->boxOffice;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;
        return $this;
    }

    public function addDirectors(Director $director)
    {
        if (!$this->director->contains($director)) {
            $this->director->add($director);
        }
    }

    public function removeDirectors(Director $director)
    {
        if ($this->director->contains($director)) {
            $this->director->removeElement($director);
        }
    }

    public function getDirectors(): Collection
    {
        return $this->director;
    }

    public function addWriters(Writers $writers)
    {
        if (!$this->writers->contains($writers)) {
            $this->writers->add($writers);
        }
    }

    public function removeWriters(Writers $writers)
    {
        if ($this->writers->contains($writers)) {
            $this->writers->removeElement($writers);
        }
    }

    public function getWriters(): Collection
    {
        return $this->writers;
    }

    public function addActors(Actor $actor)
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
        }
    }

    public function removeActors(Actor $actor)
    {
        if ($this->actors->contains($actor)) {
            $this->actors->removeElement($actor);
        }
    }

    public function getActors(): ArrayCollection
    {
        return $this->actors;
    }

    public function addGenre(Genre $genre)
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }
    }

    public function removeGenre(Genre $genre)
    {
        if ($this->genre->contains($genre)) {
            $this->genre->removeElement($genre);
        }
    }

    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addRating(Rating $rating)
    {
        if (!$this->rating->contains($rating)) {
            $this->rating->add($rating);
        }
    }

    public function removeRating(Rating $rating)
    {
        if ($this->rating->contains($rating)) {
            $this->rating->removeElement($rating);
        }
    }

    public function getRating() : Collection
    {
        return $this->rating;
    }
}

