<?php

declare(strict_types=1);

namespace Ats\Domain\Common\Event;

interface DomainEvent
{
    /**
     * @return \DateTime
     */
    public function occurredOn();
}
