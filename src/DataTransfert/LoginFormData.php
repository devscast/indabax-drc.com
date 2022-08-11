<?php

declare(strict_types=1);

namespace App\DataTransfert;

/**
 * class LoginFormData.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginFormData
{
    public function __construct(
        public ?string $email = null,
        public ?string $password = null,
    ) {
    }
}
