<?php


namespace tests\unit\Employee;

use Codeception\Test\Unit;

class RemoveTest extends Unit
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->archived()->build();

        $employee->remove();

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeRemoved::class, end($evends));
    }

    public function testNotArchived()
    {
        $employee = EmployeeBuilder::instance()->build();

        $this->expectExceptionMessage('Cannot remove active employee');

        $employee->remove();
    }
}