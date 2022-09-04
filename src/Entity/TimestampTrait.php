<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * trait TimestampTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait TimestampTrait
{
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function setCreatedAtOnPrePersist(): void
    {
        if ($this->created_at === null) {
            $this->created_at = new \DateTimeImmutable();
        }
    }

    public function setUpdatedAtOnPostUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface|string $created_at): self
    {
        $this->created_at = $this->createDateTimeImmutable($created_at);

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface|string|null $updated_at): self
    {
        $this->updated_at = $this->createDateTimeImmutable($updated_at);

        return $this;
    }

    public function createDateTimeImmutable(\DateTimeInterface|string|null $date): ?\DateTimeImmutable
    {
        if (is_string($date)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $date);
            return $date === false ? null : $date;
        } elseif ($date instanceof \DateTimeInterface) {
            return \DateTimeImmutable::createFromInterface($date);
        }
        return null;
    }
}
