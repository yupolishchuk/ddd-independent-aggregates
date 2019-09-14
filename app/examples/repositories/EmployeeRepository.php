<?php

namespace app\repositories;

use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;

interface EmployeeRepository
{
    /**
     * @param EmployeeId $id
     * @return Employee
     * @throws NotFoundException
     */
    public function get(EmployeeId $id): Employee;

    public function add(Employee $employee): void;

    public function save(Employee $employee): void;

    public function remove(Employee $employee): void;

    public function nextId(): EmployeeId;
}