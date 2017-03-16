<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 15/03/2017
 * Time: 22:55
 */

namespace TCS\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function parametersAction(){
        return $this->render('TCSUserBundle:User:parameters.html.twig');
    }

    public function confirmedAction(){
        return $this->redirectToRoute('TCSCoreBundle:Core:index.html.twig');
    }
}

