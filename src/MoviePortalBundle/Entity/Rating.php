<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\RatingRepository")
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
    //TODO onetoone relation
    private $user;
    /**
     * @var Movie
     * @ORM\ManyToMany(targetEntity="MoviePortalBundle\Entity\Movie", inversedBy="rating")
     */
    private $movie;

    public function __construct()
    {
        $this->movie = new ArrayCollection();
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
}

