<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Organizer;
use App\Form\Admin\OrganizerType;
use App\Repository\OrganizerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/organizer', name: 'admin_organizer_')]
final class OrganizerController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, OrganizerRepository $repository, PaginatorInterface $paginator): Response
    {
        return $this->render('backend/domain/admin/organizer/index.html.twig', [
            'data' => $paginator->paginate(
                target: $repository->findAll(),
                page: $request->query->getInt('page', 1),
                limit: 50
            ),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrganizerRepository $repository): Response
    {
        $organizer = new Organizer();
        $form = $this->createForm(OrganizerType::class, $organizer)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($organizer, true);

            return $this->redirectSeeOther('admin_organizer_index');
        }

        return $this->renderForm(
            view: 'backend/domain/admin/organizer/new.html.twig',
            parameters: [
                'data' => $organizer,
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Organizer $organizer): Response
    {
        return $this->render('backend/domain/admin/organizer/show.html.twig', [
            'data' => $organizer,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Organizer $organizer, OrganizerRepository $repository): Response
    {
        $form = $this->createForm(OrganizerType::class, $organizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($organizer, true);

            return $this->redirectSeeOther('admin_organizer_index');
        }

        return $this->renderForm('backend/domain/admin/organizer/edit.html.twig', [
            'data' => $organizer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Organizer $organizer, OrganizerRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $organizer->getId(), (string) $request->request->get('_token'))) {
            $repository->remove($organizer, true);
        }

        return $this->redirectSeeOther('admin_organizer_index');
    }
}
