<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Employee;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {
    }

    public function store(TransactionRequest $request, Employee $employee)
    {
        $validated = $request->validated();

        $transaction = $this->transactionService->store(
            $employee,
            $validated["hours"]
        );

        return TransactionResource::make($transaction);
    }
}
