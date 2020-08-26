<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Form\UserRegisterType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController.
 */
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
        return $this->render(
            'user/login.html.twig',
            [
                'controller_name' => 'UserController',
            ]
        );
    }

    /**
     * @Route("/profile", name="profile", methods={"GET", "POST"})
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
     */
    public function userUpdatePassword(
        Request $request,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $form = $this->createFormBuilder()
            ->add('password', PasswordType::class)
            ->add('rePassword', PasswordType::class)
            ->add('Save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $this->validatePassword(
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
        }

        return $this->render(
            'user/password.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function validatePassword($password, $rePassword)
    {
        if (!LoginFormAuthenticator::comparePasswords($password, $rePassword)) {
            $this->addFlash('error', 'The passwords does not matches');

            return false;
        }

        return true;
    }

    /**
     * @Route("/account/activate/{token}", name="activate-account", methods={"GET"})
     */
    public function userActivateAccount(UserRepository $userRepository, $token)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $user->setIsActive(true);
            $user->setToken('');
            $entityManager->flush($user);
            $this->addFlash('success', 'Your account has been activated. Please Login!');

            return $this->redirectToRoute('app_login');
        }

        throw $this->createNotFoundException('The token is not valid');
    }

    /**
     * @Route("/password/recovery", name="password-recovery", methods={"GET", "POST"})
     */
    public function userPasswordRecovery(UserRepository $userRepository, Request $request, MailerInterface $mailer)
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->add('Reset', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $userRepository->findOneBy(['email' => $form['email']->getData()]);
            if ($user) {
                $time = time();
                $signer = new Sha256();
                $token = (new Builder())
                    ->withClaim('mail', $user->getEmail())
                    ->expiresAt($time + 600)
                    ->getToken($signer, new Key($_ENV['APP_SECRET']));
                $user->setToken($token);
                $entityManager->flush($user);
                $email = (new TemplatedEmail())
                    ->from($_ENV['MAILER_FROM'])
                    ->to(new Address($user->getEmail(), $user->getFirstname()))
                    ->replyTo($_ENV['MAILER_REPLY_TO'])
                    ->subject('Password recovery')
                    ->text('You asked for a password recovery.')
                    ->htmlTemplate('emails/password-recovery.html.twig')
                    ->context(['user' => $user]);

                $mailer->send($email);
            }
            $this->addFlash('success', 'Your account has been activated. Please Login!');
        }

        return $this->render(
            'user/password-recovery.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/password/recovery/{token}", name="password-recovery-token", methods={"GET", "POST"})
     */
    public function userPasswordRecoveryToken(
        UserRepository $userRepository,
        $token,
        Request $request,
        UserPasswordEncoderInterface $encoder
    ) {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $form = $this->createFormBuilder()
                ->add('password', PasswordType::class)
                ->add('rePassword', PasswordType::class)
                ->add('Save', SubmitType::class)
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $this->validatePassword(
                    $form['password']->getData(),
                    $form['rePassword']->getData()
                )) {
                $user->setPassword($encoder->encodePassword($user, $form['password']->getData()));
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Password has been changed');

                return $this->redirectToRoute('app_login');
            }

            return $this->render('user/password.html.twig', ['form' => $form->createView()]);
        }

        throw $this->createNotFoundException('The token is not valid');
    }

    /**
     * @Route("/register", name="register", methods={"GET", "POST"})
     */
    public function userRegister(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        MailerInterface $mailer
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('profile');
        }

        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);
        $error = [];

        if ($form->isSubmitted()) {
            $this->validatePassword($form['password']->getData(), $form['rePassword']->getData());

            $time = time();
            $signer = new Sha256();
            $token = (new Builder())
                ->withClaim('mail', $user->getEmail())
                ->expiresAt($time + 600)
                ->getToken($signer, new Key($_ENV['APP_SECRET']));

            $entityManager = $this->getDoctrine()->getManager();
            $user->setToken($token);
            $user->setIsActive();
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($encoder->encodePassword($user, $form['password']->getData()));
            $entityManager->persist($user);
            $entityManager->flush();
            $email = (new TemplatedEmail())
                ->from($_ENV['MAILER_FROM'])
                ->to(new Address($user->getEmail(), $user->getFirstname()))
                ->bcc($_ENV['MAILER_FROM'])
                ->replyTo($_ENV['MAILER_REPLY_TO'])
                ->subject('Your new account')
                ->text('Congratulation, your account has been created.')
                ->htmlTemplate('emails/registration.html.twig')
                ->context(
                    [
                        'user' => $user,
                    ]
                );

            $mailer->send($email);

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'user/register.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }
}
