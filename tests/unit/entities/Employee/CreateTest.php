<?php

namespace tests\unit\entities\Employee;

use tests\unit\entities\Employee\EmployeeBuilder;
use app\entities\Employee\Events\EmployeeCreated;
use app\entities\Employee\Address;
use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;
use app\entities\Employee\Name;
use app\entities\Employee\Phone;
use Codeception\Test\Unit;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $employee = new Employee(
            $id = new EmployeeId(25),
            $name = new Name("Блюр", "Ивиан", "Петрович"),
            $address = new Address("RCE2017", "Небесная обл.", "Жнецк", "Мастодонтов", 15),
            $phones = [
                new Phone(9, "100", "1000000"),
                new Phone(9, "200", "2000000")
            ]
        );

        $this->assertEquals($id, $employee->getId());
        $this->assertEquals($name, $employee->getName());
        $this->assertEquals($address, $employee->getAddress());
        $this->assertEquals($phones, $employee->getPhones());

        $this->assertNotNull($employee->getCreateDate());

        $this->assertCount(1, $statuses = $employee->getStatuses());
        $this->assertTrue(end($statuses)->isActive());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeCreated::class, end($events));
    }


    public function testWithoutPhones()
    {
        $this->expectExceptionMessage('Employee must have at least one phone number.');

        new Employee(
            new EmployeeId(25),
            new Name("Блюр", "Ивиан", "Петрович"),
            new Address("RCE2017", "Небесная обл.", "Жнецк", "Мастодонтов", 15),
            []
        );
    }

    public function testWithSamePhoneNubmers()
    {
        $this->expectExceptionMessage('Employee cannot have equal phone numbers.');

        new Employee(
            new EmployeeId(25),
            new Name("Блюр", "Ивиан", "Петрович"),
            new Address("RCE2017", "Небесная обл.", "Жнецк", "Мастодонтов", 15),
            [
                new Phone(9, "100", "1000000"),
                new Phone(9, "100", "1000000")
            ]
        );
    }


}
