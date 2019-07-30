<?php

namespace MoviePortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="MoviePortalBundle\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content_html", type="text")
     */
    private $contentHtml;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="MoviePortalBundle\Entity\Category", inversedBy="post")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var Comments
     * @ORM\OneToMany(targetEntity="MoviePortalBundle\Entity\Comments", mappedBy="post")
     */
    private $comment;

    public function __construct()
    {
        $this->comment = new ArrayCollection();
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
     * @return Post
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

    /**
     * Set contentHtml.
     *
     * @param string $contentHtml
     *
     * @return Post
     */
    public function setContentHtml($contentHtml)
    {
        $this->contentHtml = $contentHtml;

        return $this;
    }

    /**
     * Get contentHtml.
     *
     * @return string
     */
    public function getContentHtml()
    {
        return $this->contentHtml;
    }

    /**
     * Set category.
     *
     * @param string $category
     *
     * @return Post
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function addComment(Comments $comment)
    {
        if(!$this->comment->contains($comment)){
            $this->comment->add($comment);
        }
    }

    public function removeComment(Comments $comment)
    {
        if($this->comment->contains($comment))
        {
            $this->comment->remove($comment);
        }
    }

    public function getComments() : Collection
    {
        return $this->comment;
    }
}
