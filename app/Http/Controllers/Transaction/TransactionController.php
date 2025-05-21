<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        return inertia('Transaction/Index');
    }

    public function itemAssignment()
    {
        return inertia('Transaction/ItemsAssignment');
    }

    public function itemReturn()
    {
        return inertia('Transaction/ItemsReturn');
    }
    public function itemTransfer()
    {
        return inertia('Transaction/ItemsTransfer');
    }

    public function itemDisposal()
    {
        return inertia('Transaction/ItemsDisposal');
    }
}
