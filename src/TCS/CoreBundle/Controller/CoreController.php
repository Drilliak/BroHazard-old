<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 14/03/2017
 * Time: 20:23
 */

namespace TCS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CoreController extends Controller
{

    /**
     * La page d'accueil.
     */
    public function indexAction(){

        return $this->render('TCSCoreBundle:Core:index.html.twig');

    }
}