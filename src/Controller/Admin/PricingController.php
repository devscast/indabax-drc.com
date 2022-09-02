<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Pricing;
use App\Form\Admin\PricingType;
use App\Repository\PricingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin/pricing")]
final class PricingController extends AbstractController
{
    #[Route("", name: "admin_pricing_index", methods: ['GET', 'POST'])]
    public function index(Request $request, PricingRepository $repository): Response
    {
        $data = $repository->findAll();
        $pricing = count($data) === 0 ? new Pricing() : $data[0];

        $form = $this->createForm(PricingType::class, $pricing)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash("success", "les prix ont bien été configurés");
            $repository->add($pricing, true);
            return $this->redirectToRoute("admin_pricing_index");
        }

        return $this->renderForm(
            view: "domain/admin/pricing/index.html.twig",
            parameters: [
                'form' => $form
            ]
        );
    }
}
