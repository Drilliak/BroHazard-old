<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 12/03/2017
 * Time: 17:00
 */

namespace TCS\PlatformBundle\Controller;


use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use TCS\PlatformBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class UserController extends Controller
{

    public function subscribeAction(){
        $user = new User();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

        $formBuilder
            ->add('pseudo', TextType::Class)
            ->add('name', TextType::Class)
            ->add('firstName', TextType::Class)
            ->add('password',PasswordType::Class)
            ->add('birthday', BirthdayType::Class)
            ->add('email', EmailType::Class)
            ->add('gender', ChoiceType::Class, array('choices' =>array('Homme' => 'm', 'Femme' => 'w')));


        $form = $formBuilder->getForm();

        return $this->render('TCSPlatformBundle:User:subscribe.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}