<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 13/03/2017
 * Time: 20:07
 */

namespace TCS\PlatformBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{

    /**
     * Retourne les articles les plus récents.
     * @param $nbArticles nombre d'articles à retourner.
     * @return array
     */
    public function findLastArticles($nbArticles, $author = null){

        if ($author == null){
            $query = $this->_em->createQuery("SELECT a FROM TCSPlatformBundle:Article a ORDER BY a.creationDate DESC")
                ->setMaxResults($nbArticles);

            return $query->getResult();
        } else {
            $query = $this->_em->createQuery("SELECT a FROM TCSPlatformBundle:Article a JOIN a.author u WHERE u.usernameCanonical = :author ORDER BY a.creationDate DESC");
            $query->setParameter('author', $author);
            $query->setMaxResults($nbArticles);

            return $query->getResult();
        }

    }

    public function findFirstArticles($nbArticles, $author = null){
        if ($author == null){
            $query = $this->_em->createQuery("SELECT a FROM TCSPlatformBundle:Article a ORDER BY a.creationDate ASC")
                ->setMaxResults($nbArticles);

            return $query->getResult();
        } else {
            $query = $this->_em->createQuery("SELECT a FROM TCSPlatformBundle:Article a JOIN a.author u WHERE u.usernameCanonical = :author ORDER BY a.creationDate ASC");
            $query->setParameter('author', $author);
            $query->setMaxResults($nbArticles);

            return $query->getResult();
        }
    }

    public function findArticlesByAuthor($author, $nbArticles){
        $query = $this->_em->createQuery("SELECT a FROM TCSPlatformBundle:Article a JOIN a.author u WHERE u.usernameCanonical = :author");
        $query->setParameter('author', $author);
        $query->setMaxResults($nbArticles);

        return $query->getResult();
    }

}