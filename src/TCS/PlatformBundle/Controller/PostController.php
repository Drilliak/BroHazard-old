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

class PostController extends Controller
{
    public function indexAction(){

        $post1 = "coucou";
        $post2 = "les";
        $post3 = "copains";
        return $this->render('TCSPlatformBundle:Post:index.html.twig', array(
            'post1' =>$post1,
            'post2' => $post2,
            'post3' => $post3
        ));
    }
}