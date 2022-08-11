<?php

declare(strict_types=1);

namespace App\Event;

use App\DataTransfert\ContactData;

/**
 * class ContactEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class ContactEvent
{
    public function __construct(
        public readonly ContactData $data
    ) {
    }
}
