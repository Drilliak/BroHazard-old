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

class PostController extends Controller
{
    public function indexAction(){

        $posts = $this->getDoctrine()->getManager()->getRepository('TCSPlatformBundle:Article')->findAll();


        return $this->render('TCSPlatformBundle:Post:index.html.twig', array('posts' => $posts ));
    }
}
