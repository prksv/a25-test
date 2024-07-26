<?php

namespace App\Services;

use App\Models\Employee;
use Hash;

class EmployeeService
{
    public function store(string $email, string $password): Employee
    {
        return Employee::create([
            "email" => $email,
            "password" => Hash::make($password),
        ]);
    }
}
