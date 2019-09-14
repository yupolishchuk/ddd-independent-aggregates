<?php

namespace app\repositories;

use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;
use Ramsey\Uuid\Uuid;

class MemoryEmployeeRepository implements EmployeeRepository
{
    private $items = [];

    public function get(EmployeeId $id): Employee
    {
        if (!isset($this->items[$id->getId()])) {
            throw new NotFoundException('Employee not found.');
        }
        return clone $this->items[$id->getId()];
    }

    public function add(Employee $employee): void
    {
        $this->items[$employee->getId()->getId()] = $employee;
    }

    public function save(Employee $employee): void
    {
        $this->items[$employee->getId()->getId()] = $employee;
    }

    public function remove(Employee $employee): void
    {
        if ($this->items[$employee->getId()->getId()]) {
            unset($this->items[$employee->getId()->getId()]);
        }
    }

    public function nextId(): EmployeeId
    {
        return new EmployeeId(Uuid::uuid4()->toString());
    }
}