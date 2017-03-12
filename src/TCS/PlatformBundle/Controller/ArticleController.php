<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 12/03/2017
 * Time: 13:33
 */

namespace TCS\PlatformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use TCS\PlatformBundle\Entity\Article;
use TCS\PlatformBundle\Form\ArticleType;

class ArticleController extends Controller
{
    public function indexAction(){

        $articles = $this->getDoctrine()->getManager()->getRepository('TCSPlatformBundle:Article')->findAll();


        return $this->render('TCSPlatformBundle:Article:index.html.twig', array('articles' => $articles ));
    }

    public function addAction(){
        $article = new Article();
        $form = $this->get('form.factory')->create(ArticleType::class, $article);

        return $this->render('TCSPlatformBundle:Article:add.html.twig', array(
            'form' =>$form->createView(),
        ));
    }
}
