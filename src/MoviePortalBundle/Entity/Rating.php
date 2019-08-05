<?php

namespace MoviePortalBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\RatingRepository")
 * @UniqueEntity(fields={"user"})
 * @UniqueEntity(fields={"movies"})
 * @UniqueEntity(fields={"score"})
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
     * @ORM\ManyToOne(targetEntity="MoviePortalBundle\Entity\User", inversedBy="ratings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @var Movie
     * @ORM\ManyToOne(targetEntity="MoviePortalBundle\Entity\Movie", inversedBy="rating")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     */
    private $movies;
    /**
     * @var int
     * @ORM\Column(name="score", type="integer")
     * @Assert\Range(min="1", max="10")
     */
    private $score;



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

    /**
     * @return Movie
     */
    public function getMovies(): ?Movie
    {
        return $this->movies;
    }

    /**
     * @param Movie $movies
     */
    public function setMovies(Movie $movies): void
    {
        $this->movies = $movies;
    }


}

