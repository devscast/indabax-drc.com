<?php

declare(strict_types=1);

namespace App\DataTransfert;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdatePasswordData.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePasswordData
{
    public function __construct(
        public readonly User $user,
        public ?string $current = null,
        #[Assert\NotBlank]
        #[Assert\Length(min: 6, max: 4096)]
        public ?string $new = null
    ) {
    }
}
