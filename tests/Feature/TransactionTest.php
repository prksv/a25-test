<?php

use App\Models\Employee;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Random\RandomException;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @throws RandomException
     */
    public function test_transaction_accepting_successfully(): void
    {
        $employee = Employee::factory()->createOne();

        $response = $this->postJson(
            "/api/employee/{$employee->id}/transactions",
            [
                "hours" => random_int(1, 100),
            ]
        );

        $response->assertStatus(201);

        $this->assertDatabaseCount("transactions", 1);

        $this->assertDatabaseHas("transactions", [
            "id" => $response->json("id"),
            "hours" => $response->json("hours"),
            "paid" => (int) $response->json("paid"),
        ]);
    }

    public function test_transaction_paying_successfully(): void
    {
        $transactions = Transaction::factory()
            ->count(20)
            ->create([
                "paid" => false,
            ]);

        $response = $this->postJson("/api/admin/transactions/pay");

        $response->assertStatus(200);

        $paidTransactions = Transaction::whereIn(
            "id",
            $transactions->pluck("id")
        )
            ->where("paid", true)
            ->count();

        $this->assertEquals($transactions->count(), $paidTransactions);
    }

    public function test_transaction_total_amount_is_correct(): void
    {
        $transactions = Transaction::factory()->count(20)->create();

        $response = $this->get("/api/admin/transactions");

        $response->assertStatus(200);

        $amounts = collect($response->json())->values();

        foreach ($amounts as $item) {
            $employeeId = array_keys($item)[0];
            $totalHours = Transaction::unpaid()
                ->where("employee_id", $employeeId)
                ->sum("hours");

            $expectedTotalAmount =
                $totalHours * TransactionService::SALARY_RATE;

            $this->assertEquals($expectedTotalAmount, array_values($item)[0]);
        }
    }
}
