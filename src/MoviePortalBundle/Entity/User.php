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
    public $ratings;
    /**
     * @var Comments
     * @ORM\OneToMany(targetEntity="MoviePortalBundle\Entity\Comments", mappedBy="user")
     */
    public $comments;

    public function __construct()
    {
        parent::__construct();
        $this->ratings = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function addRating(Rating $rating)
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
        }
    }

    public function removeRating(Rating $rating)
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->remove($rating);
        }
    }

    public function getRating(): Collection
    {
        return $this->ratings;
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

