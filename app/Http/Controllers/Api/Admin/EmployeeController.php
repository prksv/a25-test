<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $employeeService)
    {
    }

    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();

        $employee = $this->employeeService->store(
            $validated["email"],
            $validated["password"]
        );

        return EmployeeResource::make($employee);
    }
}
