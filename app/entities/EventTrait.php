<?php

namespace app\entities;

trait EventTrait
{
    private $events = [];

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    protected function recordEvent($event): void
    {
        $this->events[] = $event;
    }
}