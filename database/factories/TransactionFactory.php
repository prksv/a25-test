<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected static ?bool $paid;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        if (Employee::count() <= 0) {
            Employee::factory()->count(10)->create();
        }

        return [
            "employee_id" => Employee::pluck("id")->random(),
            "hours" => random_int(1, 24),
            "paid" => static::$paid ?? (bool) random_int(0, 1),
        ];
    }
}
