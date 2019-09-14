<?php

namespace tests\unit\repositories;

use app\repositories\MemoryEmployeeRepository;


class MemoryEmployeeRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before(): void
    {
        $this->repository = new MemoryEmployeeRepository();
    }
}