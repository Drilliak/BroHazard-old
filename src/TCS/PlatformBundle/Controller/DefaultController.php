<?php

namespace TCS\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TCSPlatformBundle:Default:index.html.twig');
    }
}
