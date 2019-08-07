<?php

namespace app\entities\Employee\Events;

use app\entities\Employee\EmployeeId;

class EmployeeRemoved
{
    public $employeeId;

    public function __construct(EmployeeId $employeeId)
    {
        $this->employeeId = $employeeId;
    }
}