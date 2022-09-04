<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\DataTransfert\UpdatePasswordData;
use App\Entity\User;
use App\Form\Admin\UpdatePasswordType;
use App\Form\Admin\UserType;
use App\Repository\UserRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/setting')]
final class SettingController extends AbstractController
{
    #[Route('', name: 'admin_setting_index', methods: ['GET', 'POST'])]
    public function index(Request $request, UserRepository $repository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($user, true);
            $this->addFlash('success', 'votre compte a bien été mise à jour');

            return $this->redirectSeeOther('admin_setting_index');
        }

        return $this->renderForm(
            view: 'domain/admin/setting/index.html.twig',
            parameters: [
                'form' => $form,
            ]
        );
    }

    #[Route('/password', name: 'admin_setting_password', methods: ['GET', 'POST'])]
    public function password(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EventDispatcherInterface $dispatcher,
        UserRepository $repository
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $data = new UpdatePasswordData($user);
        $form = $this->createForm(UpdatePasswordType::class, $data)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (! $hasher->isPasswordValid($user, (string) $data->current)) {
                $this->addFlash('error', 'Mot de passe actuel incorrecte');
            } else {
                $user->setPassword($hasher->hashPassword($user, (string) $data->new));
                $repository->add($user, true);
                $this->addFlash('success', 'Votre mot de passe a bien été mise à jour');
            }

            return $this->redirectSeeOther('admin_setting_password');
        }

        return $this->renderForm(
            view: 'domain/admin/setting/password.html.twig',
            parameters: [
                'form' => $form,
            ]
        );
    }
}
