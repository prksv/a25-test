<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Transaction;
use Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Transaction_QB;

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
                fn(int $value, string $key) => [
                    $key => $value * self::SALARY_RATE,
                ]
            )
            ->values();
    }

    public function payAll(): int
    {
        return Transaction::unpaid()->update(["paid" => true]);
    }
}
