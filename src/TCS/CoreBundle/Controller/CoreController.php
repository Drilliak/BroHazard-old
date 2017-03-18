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
use Symfony\Component\HttpFoundation\Request;
use TCS\UserBundle\Entity\User;

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


    /**
     * @param Request $request
     * @param int $nbArticles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction(Request $request, $nbArticles = 10){
        $allowed_sorted = array('activity', 'author');

        $sort = "activity";

        if (in_array($request->query->get("sort"), $allowed_sorted)){
            $sort = ($request->query->get("sort"));
        }

        // On récupère les auteurs
        $repository = $this->getDoctrine()->getManager()->getRepository('TCSUserBundle:User');
        $users = $repository->findAll();
        $authors = array();
        foreach($users as $user){
            if ($user->hasRole('ROLE_AUTHOR') || $user->hasRole('ROLE_ADMIN')){
                $authors[] = $user;
            }
        }

        //On récupère les articles
        $articles = array();
        if ($sort == "activity"){
            $repository = $this->getDoctrine()->getManager()->getRepository('TCSPlatformBundle:Article');

            $articles = $repository->findLastArticle($nbArticles);
        }

        if ($sort == "author"){
            $author = strtolower($request->query->get("name"));

            $repository = $this->getDoctrine()->getManager()->getRepository('TCSPlatformBundle:Article');

            $articles = $repository->findArticlesByAuthor($author, $nbArticles);

        }

        return $this->render('TCSCoreBundle:Core:articles.html.twig', array('articles' => $articles, 'authors' =>$authors));
    }

}