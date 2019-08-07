<?php

namespace app\entities\Employee;

class Phones
{

    private $phones = [];

    public function __construct(array $phones)
    {
        if (!$phones) {
            throw new \DomainException('Employee must have at least one phone number.');
        }
        foreach($phones as $phone) {
            $this->add($phone);
        }
    }

    public function add(Phone $phone): void
    {
        foreach($this->phones as $item) {
            if ($item->isEqualTo($phone)) {
                throw new \DomainException('Employee cannot have equal phone numbers.');
            }
        }
        $this->phones[] = $phone;
    }

    public function remove($index): Phone
    {
        if (!isset($this->phones[$index])) {
            throw new \DomainException('Phone not found.');
        }
        if (\count($this->phones) === 1) {
            throw new \DomainException('Cannot remove the last phone.');
        }
        $phone = $this->phones[$index];
        unset($this->phones[$index]);
        return $phone;
    }

    public function getAll(): array
    {
        return $this->phones;
    }
}
