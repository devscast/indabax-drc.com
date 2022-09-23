<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\OrganizerRepository;
use App\Repository\PricingRepository;
use App\Repository\SpeakerRepository;
use App\Repository\SponsorRepository;
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
    public function index(
        OrganizerRepository $organizerRepository,
        SponsorRepository $sponsorRepository,
        SpeakerRepository $speakerRepository,
        EventRepository $eventRepository,
        PricingRepository $pricingRepository
    ): Response {
        return $this->render(
            view: 'frontend/index.html.twig',
            parameters: [
                'organizers' => $organizerRepository->findAll(),
                'sponsors' => $sponsorRepository->findAll(),
                'speakers' => $speakerRepository->findAll(),
                'pricing' => $pricingRepository->findOneBy([]),
                'event' => $eventRepository->findOneBy([], orderBy: [
                    'created_at' => 'DESC',
                ]),
            ]
        );
    }
}
