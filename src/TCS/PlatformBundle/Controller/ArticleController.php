<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 12/03/2017
 * Time: 13:33
 */

namespace TCS\PlatformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TCS\PlatformBundle\Entity\Article;
use TCS\PlatformBundle\Form\ArticleType;

class ArticleController extends Controller
{
    /**
     * Nombre des derniers articles en date à afficher
     */


    /**
     * Méthode destinée à ajouter un article dans la BDD
     */
    public function addArticleAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_AUTHOR')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux auteurs.');
        }
        $article = new Article();
        $form = $this->get('form.factory')->create(ArticleType::class, $article);


        if ($request->isMethod('POST')) {

            // On stocke les valeur du formulaire dans $article
            $form->handleRequest($request);

            // Lors de la création, on initialise la date et création et la date de dernière modification à la
            // date actuelle.
            $article->setCreationDate(new \DateTime());
            $article->setUpdateDate(new \DateTime());
            $article->setCategory(array("autre"));
            $author = $this->getUser();
            $article->setAuthor($author);

            // Si le formulaire est valide
            if ($form->isValid()) {

                // Enregistrement de l'article en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Votre article a bien été enregistré.');

                return $this->redirectToRoute('tcs_core_articles', array('sort' => 'activity'));

            }

        }

        // Si le visiteur vient d'arriver sur la page au-travers d'une requête GET ou si le formulaire contient des
        // valeurs invalides, on l'affiche à nouveau
        return $this->render('TCSPlatformBundle:Article:addArticle.html.twig', array(
            'form' => $form->createView(),
        ));


    }

    /**
     * Affiche les articles.
     *
     * @param $sort
     * @param $nbArticles nombre d'article à afficher
     * @return Response
     */
    public function displayAction($activity, $nbArticles =5){
        if ($activity == "last-creation-date"){
            $repository = $this->getDoctrine()->getManager()->getRepository('TCSPlatformBundle:Article');

            $articles = $repository->findLastArticles($nbArticles);


            return $this->render('TCSPlatformBundle:Article:lastArticles.html.twig', array('articles' => $articles));
        }
    }

    /**
     * Affiche la page articles
     *
     * @param Request $request
     * @param int $nbArticles
     * @return Response
     */
    public function showAction(Request $request, $nbArticles = 10){
        $allowedActivity = array("last-creation-date", "first-creation-date");

        $activity = "last-creation-date";

        if (in_array($request->query->get("activity"), $allowedActivity)){
            $activity = ($request->query->get("activity"));
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
        $repository = $this->getDoctrine()->getManager()->getRepository('TCSPlatformBundle:Article');
        $author = strtolower($request->query->get("author"));
        if ($activity == "last-creation-date"){
            if ($author !== ""){
                $articles = $repository->findLastArticles($nbArticles, $author);
            } else {
                $articles = $repository->findLastArticles($nbArticles);
            }
        }
        if($activity == "first-creation-date"){
            if ($author !== ""){
                $articles = $repository->findFirstArticles($nbArticles, $author);
            } else {
                $articles = $repository->findFirstArticles($nbArticles);
            }
        }


        return $this->render('TCSPlatformBundle:Article:show.html.twig', array('articles' => $articles, 'authors' =>$authors));
    }

}
