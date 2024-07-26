<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_employees_creating_successfully(): void
    {
        $email = $this->faker->email;
        $password = $this->faker->password;

        $response = $this->postJson("/api/admin/employees", [
            "email" => $email,
            "password" => $password,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas("employees", ["email" => $email]);
    }
}
