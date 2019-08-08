<?php

namespace app\services;

use app\services\dto\AddressDto;
use app\services\dto\EmployeeArchiveDto;
use app\services\dto\EmployeeCreateDto;
use app\services\dto\EmployeeReinstateDto;
use app\services\dto\NameDto;
use app\services\dto\PhoneDto;
use app\dispatchers\EventDispatcher;
use app\entities\Employee\Address;
use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;
use app\entities\Employee\Name;
use app\entities\Employee\Phone;
use app\repositories\EmployeeRepository;

class EmployeeService
{
    private $employees;
    private $dispatcher;

    public function __construct(EmployeeRepository $employees, EventDispatcher $dispatcher)
    {
        $this->employees = $employees;
        $this->dispatcher = $dispatcher;
    }

    public function create(EmployeeCreateDto $dto): void
    {
        $employee = new Employee(
            $this->employees->nextId(),
            new Name(
                $dto->name->last,
                $dto->name->first,
                $dto->name->middle
            ),
            new Address(
                $dto->address->country,
                $dto->address->region,
                $dto->address->city,
                $dto->address->street,
                $dto->address->house
            ),
            array_map(function (PhoneDto $phone) {
                return new Phone(
                    $phone->country,
                    $phone->code,
                    $phone->number
                );
            }, $dto->phones)
        );
        $this->employees->add($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }

    public function rename(EmployeeId $id, NameDto $dto): void
    {
        $employee = $this->employees->get($id);
        $employee->rename(new Name(
            $dto->last,
            $dto->first,
            $dto->middle
        ));
        $this->employees->save($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }

    public function changeAddress(EmployeeId $id, AddressDto $dto): void
    {
        $employee = $this->employees->get($id);
        $employee->changeAddress(new Address(
            $dto->country,
            $dto->region,
            $dto->city,
            $dto->street,
            $dto->house
        ));
        $this->employees->save($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }

    public function addPhone(EmployeeId $id, PhoneDto $dto): void
    {
        $employee = $this->employees->get($id);
        $employee->addPhone(new Phone(
            $dto->country,
            $dto->code,
            $dto->number
        ));
        $this->employees->save($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }

    public function removePhone(EmployeeId $id, $index): void
    {
        $employee = $this->employees->get($id);
        $employee->removePhone($index);
        $this->employees->save($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }

    public function archive(EmployeeId $id, EmployeeArchiveDto $dto): void
    {
        $employee = $this->employees->get($id);
        $employee->archive($dto->date);
        $this->employees->save($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }

    public function reinstate(EmployeeId $id, EmployeeReinstateDto $dto): void
    {
        $employee = $this->employees->get($id);
        $employee->reinstate($dto->date);
        $this->employees->save($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }

    public function remove(EmployeeId $id): void
    {
        $employee = $this->employees->get($id);
        $employee->remove();
        $this->employees->remove($employee);
        $this->dispatcher->dispatch($employee->releaseEvents());
    }
}