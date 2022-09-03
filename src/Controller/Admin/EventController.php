<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Event;
use App\Form\Admin\EventType;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/event', name: 'admin_event_')]
class EventController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, EventRepository $repository, PaginatorInterface $paginator): Response
    {
        return $this->render('domain/admin/event/index.html.twig', [
            'data' => $paginator->paginate(
                target: $repository->findAll(),
                page: $request->query->getInt('page', 1),
                limit: 50
            ),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EventRepository $repository): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($event, true);

            return $this->redirectSeeOther('admin_event_index');
        }

        return $this->renderForm(
            view: 'domain/admin/event/new.html.twig',
            parameters: [
                'data' => $event,
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(event $event): Response
    {
        return $this->render('domain/admin/event/show.html.twig', [
            'data' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, event $event, EventRepository $repository): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($event, true);

            return $this->redirectSeeOther('admin_event_index');
        }

        return $this->renderForm('domain/admin/event/edit.html.twig', [
            'data' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, event $event, EventRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), (string) $request->request->get('_token'))) {
            $repository->remove($event, true);
        }

        return $this->redirectSeeOther('admin_event_index');
    }
}
