<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\MovieRepository")
 */
class Movie
{
    //TODO array Collection seters and geters
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
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Rating", mappedBy="movie")
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
     * Set rating
     *
     * @param string $rating
     *
     * @return Movie
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
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
}

