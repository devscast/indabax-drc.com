<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * trait ImageTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait ImageTrait
{
    public function getImageFile(): ?File
    {
        return $this->image_file;
    }

    public function setImageFile(?File $file): self
    {
        $this->image_file = $file;
        if ($this->image_file instanceof UploadedFile) {
            $this->updated_at = new \DateTimeImmutable();
        }
        return $this;
    }
}
