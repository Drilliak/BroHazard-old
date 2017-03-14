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
    public function findLastArticle($nbArticles){
        $query = $this->_em->createQuery("SELECT a FROM TCSPlatformBundle:Article a ORDER BY a.creationDate DESC")
        ->setMaxResults($nbArticles);

        return $query->getResult();
    }
}