<?php

declare(strict_types=1);

namespace App\DataTransfert;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * class ContactData.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class ContactData
{
    #[Assert\NotBlank]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;

    #[Assert\NotBlank]
    public ?string $subject = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 10)]
    public ?string $message = null;
}
