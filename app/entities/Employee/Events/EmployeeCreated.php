<?php

namespace app\entities\Employee\Events;

use app\entities\Employee\EmployeeId;

class EmployeeCreated
{
    public $employeeId;

    public function __construct(EmployeeId $employeeId)
    {
        $this->employeeId = $employeeId;
    }
}