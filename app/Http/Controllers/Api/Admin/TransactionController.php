<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Employee;
use App\Models\Transaction;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {
    }

    public function index()
    {
        $total = $this->transactionService->getTotalUnpaid();

        return response($total);
    }

    public function pay()
    {
        $count = $this->transactionService->payAll();

        return response("Total {$count} transactions was paid.");
    }
}
