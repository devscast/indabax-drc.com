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
        if (is_string($created_at)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $created_at);
            $this->created_at = $date === false ? null : $date;
        } elseif ($created_at instanceof \DateTimeInterface) {
            $this->created_at = \DateTimeImmutable::createFromInterface($created_at);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface|string|null $updated_at): self
    {
        if (is_string($updated_at)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $updated_at);
            $this->updated_at = $date === false ? null : $date;
        } elseif ($updated_at instanceof \DateTimeInterface) {
            $this->updated_at = \DateTimeImmutable::createFromInterface($updated_at);
        } else {
            $this->updated_at = $updated_at;
        }

        return $this;
    }
}
