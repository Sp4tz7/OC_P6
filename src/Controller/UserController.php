<?php

namespace App\Controller;

use App\Form\UserProfileType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
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
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function logoutUser(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render(
            'user/login.html.twig',
            [
                'controller_name' => 'UserController',
            ]
        );
    }

    /**
     * @Route("/profile", name="profile", methods={"GET", "POST"})
     * @param Request    $request
     * @param Filesystem $filesystem
     * @return Response
     */
    public function userProfile(Request $request, Filesystem $filesystem): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $oldAvatar = $user->getAvatar();
            $avatarFile = $form['avatar']->getData();
            if ($avatarFile) {
                $filename = md5(uniqid()).'.'.$avatarFile->guessExtension();
                $avatarFile->move(
                    $this->getParameter('avatar_img_directory'),
                    $filename
                );
                if ($oldAvatar) {
                    $filesystem->remove($this->getParameter('avatar_img_directory').'/'.$oldAvatar);
                }
                $user->setAvatar($filename);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your profile has been updated');
        }

        return $this->render(
            'user/profile.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/profile/password", name="profile-password", methods={"GET", "POST"})
     * @param Request                      $request
     * @param LoginFormAuthenticator       $login
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function userUpdatePassword(
        Request $request,
        LoginFormAuthenticator $login,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $form = $this->createFormBuilder()
            ->add('password', PasswordType::class)
            ->add('rePassword', PasswordType::class)
            ->add('Save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($login::comparePasswords(
                $form['password']->getData(),
                $form['rePassword']->getData()
            )) {
                $entityManager = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                $user->setPassword($encoder->encodePassword($user, $form['password']->getData()));
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Password has been changed');

                return $this->redirectToRoute('profile');

            } else {
                $this->addFlash('error', 'The passwords does not matches');
            }
        }

        return $this->render(
            'user/password.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
