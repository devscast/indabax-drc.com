<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\User;
use App\Event\UserCreatedEvent;
use App\Form\Admin\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, UserRepository $repository, PaginatorInterface $paginator): Response
    {
        return $this->render('domain/admin/user/index.html.twig', [
            'data' => $paginator->paginate(
                target: $repository->findAll(),
                page: $request->query->getInt('page', 1),
                limit: 50
            ),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        UserRepository $repository,
        UserPasswordHasherInterface $hasher,
        EventDispatcherInterface $dispatcher
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = (string) $this->generateDefaultPassword();
            $user->setPassword($hasher->hashPassword($user, $password));
            $repository->add($user, true);
            $dispatcher->dispatch(new UserCreatedEvent($user, $password));

            return $this->redirectSeeOther('admin_user_index');
        }

        return $this->renderForm(
            view: 'domain/admin/user/new.html.twig',
            parameters: [
                'data' => $user,
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), (string) $request->request->get('_token'))) {
            $repository->remove($user, true);
        }

        return $this->redirectSeeOther('admin_user_index');
    }

    private function generateDefaultPassword(): int
    {
        return random_int(10 ** (6 - 1), 10 ** 6 - 1);
    }
}
