<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\UserCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

#[AsEventListener(event: UserCreatedEvent::class)]
final class UserCreatedEventListener
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(UserCreatedEvent $event): void
    {
        $message = (new Email())
            ->from(new Address('noreply@indabax-drc.org', 'IndabaX DRC'))
            ->to(new Address((string) $event->user->getEmail()))
            ->subject('Accès à votre compte administrateur indabax-drc.org')
            ->text(
                <<< MSG
Votre compte administrateur indabax-drc.org a été créé avec succès
- Lien de connexion : https://indabax-drc.org/login
- Votre identifiant : {$event->user->getEmail()} 
- Votre mot de passe par défaut : {$event->defaultPassword}
MSG
            );

        try {
            $this->mailer->send($message);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }
    }
}
