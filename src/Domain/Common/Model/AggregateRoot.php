<?php

declare(strict_types=1);

namespace Ats\Domain\Common\Model;

use Ats\Domain\Common\Event\DomainEvent;

abstract class AggregateRoot
{

    protected $recordedEvents = [];

    public function recordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function clearEvents()
    {
        $this->recordedEvents = [];
    }

    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }

    protected function publish(DomainEvent $event)
    {
        $this->apply($event);
        $this->record($event);
    }

    protected function publishAndDispatch(DomainEvent $event)
    {
        $this->apply($event);
        $this->record($event);
        // @todo dispatch
    }

    protected function apply(DomainEvent $event)
    {
        $method = 'apply' . get_class($event);

        if (method_exists($this, $method)) {
            $this->$method($event);
        }
    }

    protected function record(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
    }
}