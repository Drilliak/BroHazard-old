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

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR')) {
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

            // Si le formulaire est valide
            if ($form->isValid()) {

                // Enregistrement de l'article en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Votre article a bien été enregistré.');

                return $this->redirectToRoute('tcs_platform_homepage');

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
    public function displayAction($sort, $nbArticles){
        if ($sort == "activity"){
            $repository = $this->getDoctrine()->getManager()->getRepository('TCSPlatformBundle:Article');

            $articles = $repository->findLastArticle($nbArticles);


            return $this->render('TCSPlatformBundle:Article:lastArticles.html.twig', array('articles' => $articles));
        }
    }

}
