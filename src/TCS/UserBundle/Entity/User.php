<?php

namespace TCS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="TCS\UserBundle\Repository\UserRepository")
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
     * @ORM\OneToMany(targetEntity="TCS\PlatformBundle\Entity\Article", mappedBy="author")
     */
    protected $articles;

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
     * Add article
     *
     * @param \TCS\PlatformBundle\Entity\Article $article
     *
     * @return User
     */
    public function addArticle(\TCS\PlatformBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        $article->setAuthor($this);

        return $this;
    }

    /**
     * Remove article
     *
     * @param \TCS\PlatformBundle\Entity\Article $article
     */
    public function removeArticle(\TCS\PlatformBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
