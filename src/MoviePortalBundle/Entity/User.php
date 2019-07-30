<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Rating
     * @ORM\OneToMany(targetEntity="MoviePortalBundle\Entity\Rating", mappedBy="user")
     */
    public $movieRating;
    /**
     * @var Comments
     * @ORM\OneToMany(targetEntity="MoviePortalBundle\Entity\Comments", mappedBy="user")
     */
    public $comments;

    public function __construct()
    {
        parent::__construct();
        $this->movieRating = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function addMovieRating(Rating $movieRating)
    {
        if (!$this->movieRating->contains($movieRating)) {
            $this->movieRating->add($movieRating);
        }
    }

    public function removeMovieRating(Rating $movieRating)
    {
        if ($this->movieRating->contains($movieRating)) {
            $this->movieRating->remove($movieRating);
        }
    }

    public function getMovieRating(): Collection
    {
        return $this->movieRating;
    }

    public function addComment(Comments $comment)
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }

    public function removeComment(Comments $comment)
    {
        if ($this->comments->contains($comment)) {
            $this->comments->remove($comment);
        }
    }

    public function getComment(): Collection
    {
        return $this->comments;
    }
}

