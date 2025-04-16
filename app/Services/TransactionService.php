<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;


class TransactionService
{
    protected $transactionService;

    public function __construct(TransactionRepository $transactionService)
    {
        $this->transactionService = $transactionService;
    }
}
