<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TalkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TalkRepository::class)]
class Talk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Speaker $speaker = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $schedule_at = null;

    #[ORM\ManyToOne(inversedBy: 'talks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSpeaker(): ?Speaker
    {
        return $this->speaker;
    }

    public function setSpeaker(?Speaker $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }

    public function getScheduleAt(): ?\DateTimeImmutable
    {
        return $this->schedule_at;
    }

    public function setScheduleAt(\DateTimeImmutable $schedule_at): self
    {
        $this->schedule_at = $schedule_at;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
