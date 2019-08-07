<?php


namespace tests\unit\entites\Employee;

use app\entities\Employee\Phone;
use app\entities\Employee\Events\EmployeePhoneAdded;
use app\entities\Employee\Events\EmployeePhoneRemoved;
use tests\unit\entities\Employee\EmployeeBuilder;
use Codeception\Test\Unit;

class PhoneTest extends Unit
{
    public function testAdd()
    {
        $employee = EmployeeBuilder::instance()->build();

        $employee->addPhone($phone = new Phone(7, '111', '1000000'));

        $this->assertNotEmpty($phones = $employee->getPhones());
        $this->assertEquals($phone, end($phones));

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeePhoneAdded::class, end($events));
    }

    public function testAddExists()
    {
        $employee = EmployeeBuilder::instance()
            ->withPhones([$phone = new Phone(7, '111', '1000000')])
            ->build();
        $this->expectExceptionMessage('Employee cannot have equal phone numbers.');

        $employee->addPhone($phone);
    }

    public function testRemove()
    {
        $employee = EmployeeBuilder::instance()
            ->withPhones([
                new Phone(7, '100', '1000000'),
                new Phone(7, '100', '2000000'),
                ])
            ->build();

        $this->assertCount(2, $employee->getPhones());

        $employee->removePhone(1);

        $this->assertCount(1, $employee->getPhones());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeePhoneRemoved::class, end($events));
    }

    public function testRemoveNotExists()
    {
        $employee = EmployeeBuilder::instance()->build();
        $this->expectExceptionMessage('Phone not found.');

        $employee->removePhone(42);
    }

    public function testRemoveLast()
    {
        $employee = EmployeeBuilder::instance()
            ->withPhones([
                new Phone(7, '111', '1000000'),
            ])
            ->build();

        $this->expectExceptionMessage('Cannot remove the last phone.');

        $employee->removePhone(0);
    }
}