<?php

declare(strict_types=1);

namespace App\Controller;

use App\DataTransfert\ContactData;
use App\Event\ContactEvent;
use App\Form\ContactForm;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class ContactController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact_index', methods: ['GET', 'POST'])]
    public function contact(Request $request, EventDispatcherInterface $dispatcher): Response
    {
        $data = new ContactData();
        $form = $this->createForm(ContactForm::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dispatcher->dispatch(new ContactEvent($data));
            $this->addFlash(
                type: 'success',
                message: 'Merci pour votre message, nous vous répondrons dans les plus brefs délais.'
            );
            return $this->redirectSeeOther('app_index');
        }

        return $this->renderForm(
            view: 'frontend/contact.html.twig',
            parameters: [
                'form' => $form,
            ]
        );
    }
}
