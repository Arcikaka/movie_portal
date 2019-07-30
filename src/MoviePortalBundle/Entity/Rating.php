<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\RatingRepository")
 * @UniqueEntity(fields={"user","movies","score"})
 */
class Rating
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
     * @var User
     * @ORM\ManyToOne(targetEntity="MoviePortalBundle\Entity\User", inversedBy="movieRating")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @var Movie
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Movie", inversedBy="rating")
     */
    private $movies;
    /**
     * @var int
     * @ORM\Column(name="score", type="integer")
     * @Assert\Range(min="1", max="10")
     */
    private $score;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->user = new ArrayCollection();
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


    public function addMovies(Movie $movie)
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
        }
    }

    public function removeMovies(Movie $movie)
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
        }
    }

    public function getMovies(): Collection
    {
        return $this->movies;
    }

    /**
     * @return int
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }


}

