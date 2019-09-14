<?php

namespace app\entities\Employee\Events;

use app\entities\Employee\EmployeeId;
use app\entities\Employee\Name;

class EmployeeRenamed
{
    public $employeeId;
    public $name;

    public function __construct(EmployeeId $employeeId, Name $name)
    {
        $this->employeeId = $employeeId;
        $this->name = $name;
    }
}