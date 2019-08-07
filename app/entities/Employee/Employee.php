<?php

namespace app\entities\Employee;

use app\entities\AggregateRoot;
use app\entities\Employee\Events;
use app\entities\EventTrait;

class Employee implements AggregateRoot
{
    use EventTrait;

    private $id;
    private $name;
    private $address;
    private $phones;
    private $createDate;
    private $statuses = [];

    public function __construct(EmployeeId $id, Name $name, Address $address, array $phones)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->phones = new Phones($phones);
        $this->createDate = new \DateTimeImmutable();
        $this->addStatus(Status::ACTIVE, $this->createDate);
        $this->recordEvent(new Events\EmployeeCreated($this->id));
    }

    public function rename(Name $name): void
    {
        $this->name = $name;
        $this->recordEvent(new Events\EmployeeRenamed($this->id, $name));
    }

    public function changeAddress(Address $address): void
    {
        $this->address = $address;
        $this->recordEvent(new Events\EmployeeAddressChanged($this->id, $address));
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones->add($phone);
        $this->recordEvent(new Events\EmployeePhoneAdded($this->id, $phone));
    }

    public function removePhone($index): void
    {
        $phone = $this->phones->remove($index);
        $this->recordEvent(new Events\EmployeePhoneRemoved($this->id, $phone));
    }

    public function archive(\DateTimeImmutable $date): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('Employee is already archived.');
        }
        $this->addStatus(Status::ARCHIVED, $date);
        $this->recordEvent(new Events\EmployeeArchived($this->id, $date));
    }

    public function reinstate(\DateTimeImmutable $date): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Employee is not already archived.');
        }
        $this->addStatus(Status::ARCHIVED, $date);
        $this->recordEvent(new Events\EmployeeReinstantiated($this->id, $date));
    }

    public function remove(): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Cannot remove active employee.');
        }
        $this->recordEvent(new Events\EmployeeRemoved($this->id));
    }

    public function isActive(): bool
    {
        return $this->getCurrentStatus()->isActive();
    }

    public function isArchived(): bool
    {
        return $this->getCurrentStatus()->isArchived();
    }

    private function addStatus($value, \DateTimeImmutable $date): void
    {
        $this->statuses[] = new Status($value, $date);
    }

    private function getCurrentStatus(): Status
    {
        return end($this->statuses);
    }

    public function getPhones(): array { return $this->phones->getAll(); }
    public function getId(): EmployeeId { return $this->id; }
    public function getName(): Name { return $this->name; }
    public function getAddress(): Address { return $this->address; }
    public function getCreateDate(): \DateTimeImmutable { return $this->createDate; }
    public function getStatuses(): array { return $this->statuses; }
}