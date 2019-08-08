<?php

namespace tests\unit\repositories;

use app\repositories\MemoryEmployeeRepository;


class MemoryEmployeeRepositoryTest extends BaseRepositoriesTest
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