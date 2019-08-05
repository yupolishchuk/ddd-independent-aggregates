<?php

$employee = new Employee(
    new EmployeeId(25),
    new Name("Блюр", "Ивиан", "Петрович"),
    new Address("RCE2017", "Небесная обл.", "Жнецк", "Мастодонтов", 15),
    [
        new Phone(9, "100", "1000000"),
        new Phone(9, "200", "2000000")
    ]
);