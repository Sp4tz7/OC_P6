<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function loginUser(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $session = new Session();
            $session->getFlashBag()->add('success', ['title' => 'Succès', 'content' => 'Connexion réussie']);

            return $this->redirectToRoute('profile');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logoutUser(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function userProfile(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('base.html.twig', [
        ]);
    }
}
