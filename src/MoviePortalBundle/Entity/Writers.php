<?php

namespace MoviePortalBundle\Entity;

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

    private $name;

    private $surname;

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
}

