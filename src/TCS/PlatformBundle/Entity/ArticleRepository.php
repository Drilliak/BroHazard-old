<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 13/03/2017
 * Time: 20:07
 */

namespace TCS\PlatformBundle\Entity;


use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{

    public function findLastArticle(){

    }
}