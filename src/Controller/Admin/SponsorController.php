<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Sponsor;
use App\Form\Admin\SponsorType;
use App\Repository\SponsorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sponsor', name: 'admin_sponsor_')]
final class SponsorController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, SponsorRepository $repository, PaginatorInterface $paginator): Response
    {
        return $this->render('backend/domain/admin/sponsor/index.html.twig', [
            'data' => $paginator->paginate(
                target: $repository->findAll(),
                page: $request->query->getInt('page', 1),
                limit: 50
            ),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, SponsorRepository $repository): Response
    {
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($sponsor, true);

            return $this->redirectSeeOther('admin_sponsor_index');
        }

        return $this->renderForm(
            view: 'backend/domain/admin/sponsor/new.html.twig',
            parameters: [
                'data' => $sponsor,
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Sponsor $sponsor): Response
    {
        return $this->render('backend/domain/admin/sponsor/show.html.twig', [
            'data' => $sponsor,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sponsor $sponsor, SponsorRepository $repository): Response
    {
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($sponsor, true);

            return $this->redirectSeeOther('admin_sponsor_index');
        }

        return $this->renderForm('backend/domain/admin/sponsor/edit.html.twig', [
            'data' => $sponsor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Sponsor $sponsor, SponsorRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sponsor->getId(), (string) $request->request->get('_token'))) {
            $repository->remove($sponsor, true);
        }

        return $this->redirectSeeOther('admin_sponsor_index');
    }
}
