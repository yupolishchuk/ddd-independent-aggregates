<?php


namespace tests\unit\Employee;


use Codeception\Test\Unit;


class RenameTest extends Unit
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->build();

        $employee->rename($name = new Name('New', 'Test', 'Name'));
        $this->assertEquals($name, $employee->getName());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeRenamed::class, end($events));
    }
}