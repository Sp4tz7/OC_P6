<?php

namespace App\Manager;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerManager
{
    private $mailer;

    /**
     * MailerManager constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendPasswordRecoveryMail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from($_ENV['MAILER_FROM'])
            ->to(new Address($user->getEmail(), $user->getFirstname()))
            ->replyTo($_ENV['MAILER_REPLY_TO'])
            ->subject('Password recovery')
            ->text('You asked for a password recovery.')
            ->htmlTemplate('emails/password-recovery.html.twig')
            ->context(['user' => $user]);
        $this->send($email);
    }

    private function send($email)
    {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new TransportException($e);
        }
    }

    public function sendNewActivationEmail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from($_ENV['MAILER_FROM'])
            ->to(new Address($user->getEmail(), $user->getFirstname()))
            ->bcc($_ENV['MAILER_FROM'])
            ->replyTo($_ENV['MAILER_REPLY_TO'])
            ->subject('Account activation')
            ->text('Activate your account')
            ->htmlTemplate('emails/registration.html.twig')
            ->context(
                [
                    'user' => $user,
                ]
            );

        $this->send($email);
    }

    public function sendNewRegistrationEmail(User $user)
    {
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

        $this->send($email);
    }
}
