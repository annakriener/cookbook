<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 27.05.2015
 * Time: 16:03
 */

namespace CookbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CookbookBundle\Entity\Registration;
use CookbookBundle\Form\Type\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller {

    /**
     * @Route("/register", name="account_register")
     */
    public function registerAction() {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        $registration = new Registration();
        $registerForm = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('account_create'),
        ));

        return $this->render(
            'CookbookBundle:user-management:register.html.twig',
            array('registerForm' => $registerForm->createView())
        );
    }

    /**
     * @Route("/register/create", name="account_create")
     */
    public function createAction(Request $request) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();
        $registerForm = $this->createForm(new RegistrationType(), new Registration());
        $registerForm->handleRequest($request);

        if ($registerForm->isValid()) {
            $registration = $registerForm->getData();
            $user = $registration->getUser();
            $plainPassword = $user->getPassword();

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'CookbookBundle:user-management:register.html.twig',
            array('registerForm' => $registerForm->createView())
        );
    }

    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('CookbookBundle:user-management:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}
