<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $event_starts_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $event_ends_at = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $google_form_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $google_map_link = null;

    #[ORM\ManyToMany(targetEntity: Speaker::class)]
    private Collection $speakers;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->speakers = new ArrayCollection();
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

    public function getEventStartsAt(): ?\DateTimeImmutable
    {
        return $this->event_starts_at;
    }

    public function setEventStartsAt(?\DateTimeInterface $event_starts_at): self
    {
        $this->event_starts_at = $this->createDateTimeImmutable($event_starts_at);

        return $this;
    }

    public function getEventEndsAt(): ?\DateTimeImmutable
    {
        return $this->event_ends_at;
    }

    public function setEventEndsAt(?\DateTimeInterface $event_ends_at): self
    {
        $this->event_ends_at = $this->createDateTimeImmutable($event_ends_at);

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getGoogleFormLink(): ?string
    {
        return $this->google_form_link;
    }

    public function setGoogleFormLink(?string $google_form_link): self
    {
        $this->google_form_link = $google_form_link;

        return $this;
    }

    public function getGoogleMapLink(): ?string
    {
        return $this->google_map_link;
    }

    public function setGoogleMapLink(?string $google_map_link): self
    {
        $this->google_map_link = $google_map_link;

        return $this;
    }

    /**
     * @return Collection<int, Speaker>
     */
    public function getSpeakers(): Collection
    {
        return $this->speakers;
    }

    public function addSpeaker(Speaker $speaker): self
    {
        if (!$this->speakers->contains($speaker)) {
            $this->speakers->add($speaker);
        }

        return $this;
    }

    public function removeSpeaker(Speaker $speaker): self
    {
        $this->speakers->removeElement($speaker);

        return $this;
    }
}
