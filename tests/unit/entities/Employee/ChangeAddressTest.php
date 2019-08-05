<?php


namespace tests\unit\Employee;

use Codeception\Test\Unit;

class ChangeAddressTest extends Unit
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->build();

        $employee->changeAddress($address = new Address('New', 'Test', 'Address'));
        $this->assertEquals($address, $employee->getAddress());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeAddressChanged::class, end($events));
    }
}