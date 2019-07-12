<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var Post
     * @ORM\OneToMany(targetEntity="MoviePortalBundle\Entity\Post", mappedBy="category")
     */
    private $post;

    public function __construct()
    {
        $this->post = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function addPost(Post $post)
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
        }
    }

    public function removePost(Post $post)
    {
        if ($this->post->contains($post)) {
            $this->post->removeElement($post);
        }
    }

    public function getPost(): Collection
    {
        return $this->post;
    }
}
