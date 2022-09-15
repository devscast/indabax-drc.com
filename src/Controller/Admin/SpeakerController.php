<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Speaker;
use App\Form\Admin\SpeakerType;
use App\Repository\SpeakerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/speaker', name: 'admin_speaker_')]
final class SpeakerController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, SpeakerRepository $repository, PaginatorInterface $paginator): Response
    {
        return $this->render('backend/domain/admin/speaker/index.html.twig', [
            'data' => $paginator->paginate(
                target: $repository->findAll(),
                page: $request->query->getInt('page', 1),
                limit: 50
            ),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpeakerRepository $repository): Response
    {
        $speaker = new Speaker();
        $form = $this->createForm(SpeakerType::class, $speaker)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $speaker->setSlug((new AsciiSlugger())->slug((string) $speaker->getName())->toString());
            $repository->add($speaker, true);

            return $this->redirectSeeOther('admin_speaker_index');
        }

        return $this->renderForm(
            view: 'backend/domain/admin/speaker/new.html.twig',
            parameters: [
                'data' => $speaker,
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Speaker $speaker): Response
    {
        return $this->render('backend/domain/admin/speaker/show.html.twig', [
            'data' => $speaker,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Speaker $speaker, SpeakerRepository $repository): Response
    {
        $form = $this->createForm(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $speaker->setSlug((new AsciiSlugger())->slug((string) $speaker->getName())->toString());
            $repository->add($speaker, true);

            return $this->redirectSeeOther('admin_speaker_index');
        }

        return $this->renderForm('backend/domain/admin/speaker/edit.html.twig', [
            'data' => $speaker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Speaker $speaker, SpeakerRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $speaker->getId(), (string) $request->request->get('_token'))) {
            $repository->remove($speaker, true);
        }

        return $this->redirectSeeOther('admin_speaker_index');
    }
}
