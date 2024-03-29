<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 14/03/2017
 * Time: 20:23
 */

namespace TCS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class CoreController extends Controller
{

    /**
     * La page d'accueil.
     */
    public function indexAction(){

        return $this->render('TCSCoreBundle:Core:index.html.twig');

    }

    /**
     * @param $streamer
     */
    public function streamAction($streamer){
        $streamUrl = "";
        $chatUrl = "";
        $liveRedirection = "";
        switch($streamer){
            case "Drilliak":
                $streamUrl = "https://player.twitch.tv/?channel=drilliak";
                $chatUrl = "https://www.twitch.tv/drilliak/chat?popout=";
                $liveRedirection = "https://www.twitch.tv/drilliak?tt_medium=live_embed&tt_content=text_link";
                break;
            case "Rolesafe":
                $streamUrl = "https://player.twitch.tv/?channel=rolesafe";
                $chatUrl = "https://www.twitch.tv/rolesafe/chat?popout=";
                $liveRedirection = "https://www.twitch.tv/rolesafe?tt_medium=live_embed&tt_content=text_link";
                break;
            case 'Nekaator':
                $streamUrl = "https://player.twitch.tv/?channel=nekaator";
                $chatUrl = "https://www.twitch.tv/nekaator/chat?popout=";
                $liveRedirection = "https://www.twitch.tv/nekaator?tt_medium=live_embed&tt_content=text_link";
                break;
            case 'flammespectrum':
                $streamUrl = "https://player.twitch.tv/?channel=flammespectrum";
                $chatUrl = "https://www.twitch.tv/flammespectrum/chat?popout=";
                $liveRedirection = "https://www.twitch.tv/flammespectrum?tt_medium=live_embed&tt_content=text_link";
                break;

        }



        if ($streamUrl != "" && $chatUrl != ""){
            return $this->render('TCSCoreBundle:Core:stream.html.twig', array(
                'streamUrl' =>  $streamUrl,
                'chatUrl' => $chatUrl,
                'liveRedirection' => $liveRedirection
            ));
        }
        throw new NotFoundHttpException('Page inexistante');

    }

    public function adminAction(){
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux administateurs.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('TCSUserBundle:User');

        $users = $repository->findBy(array(), array('usernameCanonical' => 'asc'));

        return $this->render('TCSCoreBundle:Core:admin.html.twig', array('users' => $users));
    }



}