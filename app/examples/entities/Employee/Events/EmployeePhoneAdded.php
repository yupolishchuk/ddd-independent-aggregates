<?php

namespace app\entities\Employee\Events;

use app\entities\Employee\EmployeeId;
use app\entities\Employee\Phone;

class EmployeePhoneAdded
{
    public $employeeId;
    public $phone;

    public function __construct(EmployeeId $employeeId, Phone $phone)
    {
        $this->employeeId = $employeeId;
        $this->phone = $phone;
    }
}