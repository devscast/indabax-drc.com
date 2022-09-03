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

    #[ORM\Column]
    private ?\DateTimeImmutable $registration_starts_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $registration_ends_at = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Talk::class, orphanRemoval: true)]
    private Collection $talks;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lng = null;

    public function __construct()
    {
        $this->talks = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
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

    public function getRegistrationStartsAt(): ?\DateTimeImmutable
    {
        return $this->registration_starts_at;
    }

    public function setRegistrationStartsAt(?\DateTimeInterface $registration_starts_at): self
    {
        $this->registration_starts_at = $this->createDateTimeImmutable($registration_starts_at);

        return $this;
    }

    public function getRegistrationEndsAt(): ?\DateTimeImmutable
    {
        return $this->registration_ends_at;
    }

    public function setRegistrationEndsAt(?\DateTimeInterface $registration_ends_at): self
    {
        $this->registration_ends_at = $this->createDateTimeImmutable($registration_ends_at);

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

    /**
     * @return Collection<int, Talk>
     */
    public function getTalks(): Collection
    {
        return $this->talks;
    }

    public function addTalk(Talk $talk): self
    {
        if (! $this->talks->contains($talk)) {
            $this->talks->add($talk);
            $talk->setEvent($this);
        }

        return $this;
    }

    public function removeTalk(Talk $talk): self
    {
        if ($this->talks->removeElement($talk)) {
            // set the owning side to null (unless already changed)
            if ($talk->getEvent() === $this) {
                $talk->setEvent(null);
            }
        }

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

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
