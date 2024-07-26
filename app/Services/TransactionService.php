<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Transaction;

class TransactionService
{
    const SALARY_RATE = 200;

    public function store(Employee $employee, int $hours): Transaction
    {
        return $employee->transactions()->create(["hours" => $hours]);
    }

    public function getTotalUnpaid()
    {
        $total = Transaction::getTotalHours();

        return $total
            ->map(
                fn(int $totalHours, string $employeeId) => [
                    $employeeId => $totalHours * self::SALARY_RATE,
                ]
            )
            ->values();
    }

    public function payAll(): int
    {
        return Transaction::unpaid()->update(["paid" => true]);
    }
}
