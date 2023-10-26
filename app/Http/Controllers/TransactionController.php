<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\GetListTransactionRequest;
use App\Http\Requests\GetListWalletRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function __construct(TransactionService $transactionService)
    {
        $this->service = $transactionService;
    }

    public function index(GetListTransactionRequest $request)
    {
        return $this->service->index($request->validated());
    }

    public function create(CreateTransactionRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function show(int $id): JsonResponse
    {
        return $this->service->show($id);
    }
}
