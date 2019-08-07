<?php

namespace app\entities\Employee\Events;

use app\entities\Employee\EmployeeId;

class EmployeeArchived
{
    public $employeeId;
    public $date;

    public function __construct(EmployeeId $employeeId, \DateTimeImmutable $date)
    {
        $this->employeeId = $employeeId;
        $this->date = $date;
    }
}