<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Post;
use App\Entity\User;
use App\Form\Admin\PostForm;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/post', name: 'admin_post_')]
class PostController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, PostRepository $postRepository, PaginatorInterface $paginator): Response
    {
        return $this->render('domain/admin/post/index.html.twig', [
            'data' => $paginator->paginate(
                target: $postRepository->findAll(),
                page: $request->query->getInt('page', 1),
                limit: 50
            ),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $post = new Post();
        $form = $this->createForm(PostForm::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setAuthor($user);
            $post->setSlug((new AsciiSlugger())->slug((string) $post->getTitle())->toString());
            $postRepository->add($post, true);

            return $this->redirectSeeOther('admin_post_index');
        }

        return $this->renderForm('domain/admin/post/new.html.twig', [
            'data' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('domain/admin/post/show.html.twig', [
            'data' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostForm::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug((new AsciiSlugger())->slug((string) $post->getTitle())->toString());
            $postRepository->add($post, true);

            return $this->redirectSeeOther('admin_post_index');
        }

        return $this->renderForm('domain/admin/post/edit.html.twig', [
            'data' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), (string) $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectSeeOther('admin_post_index');
    }
}
