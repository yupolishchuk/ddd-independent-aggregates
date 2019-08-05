<?php


namespace tests\unit\Employee;

use Codeception\Test\Unit;

class ArchiveTest extends Unit
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->build();

        $this->assertTrue($employee->isActive());
        $this->assertFalse($employee->isArchived());

        $employee->archive($date = new \DateTimeImmutable('2019-08-05'));

        $this->assertFalse($employee->isActive());
        $this->assertTrue($employee->isArchived());

        $this->assertNotEmpty($statuses = $employee->getStatuses());
        $this->assertTrue(end($statuses)->isArchived());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeArchived::class, end($events));
    }

    public function testAlreadyArchived()
    {
        $employee = EmployeeBuilder::instance()->archived()->build();

        $this->expectExceptionMessage('Employee is already archived');
        $employee->archive(new \DateTimeImmutable('2019-08-05'));
    }
}