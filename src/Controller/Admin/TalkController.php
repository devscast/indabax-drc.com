<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Talk;
use App\Form\Admin\TalkType;
use App\Repository\TalkRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/talk', name: 'admin_talk_')]
final class TalkController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, TalkRepository $repository, PaginatorInterface $paginator): Response
    {
        return $this->render('domain/admin/talk/index.html.twig', [
            'data' => $paginator->paginate(
                target: $repository->findAll(),
                page: $request->query->getInt('page', 1),
                limit: 50
            ),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, TalkRepository $repository): Response
    {
        $talk = new Talk();
        $form = $this->createForm(TalkType::class, $talk)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $talk->setSlug((new AsciiSlugger())->slug((string) $talk->getName())->toString());
            $repository->add($talk, true);

            return $this->redirectSeeOther('admin_talk_index');
        }

        return $this->renderForm(
            view: 'domain/admin/talk/new.html.twig',
            parameters: [
                'data' => $talk,
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(talk $talk): Response
    {
        return $this->render('domain/admin/talk/show.html.twig', [
            'data' => $talk,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, talk $talk, TalkRepository $repository): Response
    {
        $form = $this->createForm(TalkType::class, $talk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $talk->setSlug((new AsciiSlugger())->slug((string) $talk->getName())->toString());
            $repository->add($talk, true);

            return $this->redirectSeeOther('admin_talk_index');
        }

        return $this->renderForm('domain/admin/talk/edit.html.twig', [
            'data' => $talk,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, talk $talk, TalkRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $talk->getId(), (string) $request->request->get('_token'))) {
            $repository->remove($talk, true);
        }

        return $this->redirectSeeOther('admin_talk_index');
    }
}
