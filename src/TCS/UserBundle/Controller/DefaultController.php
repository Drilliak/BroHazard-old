<?php

namespace TCS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TCSUserBundle:Default:index.html.twig');
    }
}
