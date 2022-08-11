<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class MainController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MainController extends AbstractController
{
    #[Route('', name: 'app_index', methods: ['GET'])]
    public function index(): Response
    {
        return new Response('hello world !');
    }
}
