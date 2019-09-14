<?php

namespace app\entities\Employee\Events;

use app\entities\Employee\EmployeeId;
use app\entities\Employee\Address;

class EmployeeAddressChanged
{
    public $employeeId;
    public $address;

    public function __construct(EmployeeId $employeeId, Address $address)
    {
        $this->employeeId = $employeeId;
        $this->address = $address;
    }
}