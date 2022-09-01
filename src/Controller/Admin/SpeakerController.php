<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/speaker')]
final class SpeakerController extends AbstractController
{
    #[Route('', name: 'admin_speaker_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('domain/admin/speaker/index.html.twig');
    }
}
