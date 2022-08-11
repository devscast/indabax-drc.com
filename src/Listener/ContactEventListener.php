<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\ContactEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

#[AsEventListener(event: ContactEvent::class)]
final class ContactEventListener
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(ContactEvent $event): void
    {
        $data = $event->data;
        $message = (new Email())
            ->from(new Address('noreply@indabax-drc.org', 'IndabaX DRC'))
            ->to(new Address('contact@indabax-drc.org', 'IndabaX DRC'))
            ->replyTo(new Address((string) $data->email, (string) $data->name))
            ->subject((string) $data->subject)
            ->text((string) $data->message);

        try {
            $this->mailer->send($message);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }
    }
}
