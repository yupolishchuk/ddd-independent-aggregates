<?php

namespace app\entities;


interface AggregateRoot
{
    public function releaseEvents();
}