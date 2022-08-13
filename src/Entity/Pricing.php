<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PricingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PricingRepository::class)]
class Pricing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $student = null;

    #[ORM\Column]
    private ?float $academic = null;

    #[ORM\Column]
    private ?float $professional = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?float
    {
        return $this->student;
    }

    public function setStudent(float $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getAcademic(): ?float
    {
        return $this->academic;
    }

    public function setAcademic(float $academic): self
    {
        $this->academic = $academic;

        return $this;
    }

    public function getProfessional(): ?float
    {
        return $this->professional;
    }

    public function setProfessional(float $professional): self
    {
        $this->professional = $professional;

        return $this;
    }
}
