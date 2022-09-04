<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\User;

/**
 * class UserCreatedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserCreatedEvent
{
    public function __construct(
        public readonly User $user,
        public readonly string $defaultPassword
    ) {
    }
}
