<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\PricingRepository;
use App\Service\YamlContentService;
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
        YamlContentService $content,
        EventRepository $repository,
        PricingRepository $pricingRepository
    ): Response {
        $event = $repository->findOneBy([], orderBy: [
            'created_at' => 'DESC',
        ]);

        $speakers = [];
        $talks = $event?->getTalks() ?? [];
        foreach ($talks as $talk) {
            $speakers[] = $talk->getSpeaker();
        }

        return $this->render(
            view: 'frontend/index.html.twig',
            parameters: [
                'committee' => $content->get('data.committee'),
                'sponsor' => $content->get('data.sponsor'),
                'speakers' => $content->get('data.speaker'),
                'pricing' => $pricingRepository->findOneBy([]),
                //'speakers' => $speakers,
                'event' => $event,
            ]
        );
    }
}
