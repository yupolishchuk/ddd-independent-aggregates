<?php


namespace tests\unit\entities\Employee;

use app\entities\Employee\Events\EmployeeRemoved;
use tests\unit\entities\Employee\EmployeeBuilder;
use Codeception\Test\Unit;

class RemoveTest extends Unit
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->archived()->build();

        $employee->remove();

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeRemoved::class, end($events));
    }

    public function testNotArchived()
    {
        $employee = EmployeeBuilder::instance()->build();

        $this->expectExceptionMessage('Cannot remove active employee.');

        $employee->remove();
    }
}