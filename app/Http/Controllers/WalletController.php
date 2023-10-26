<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetListWalletRequest;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    private WalletService $service;

    public function __construct(WalletService $walletService)
    {
        $this->service = $walletService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetListWalletRequest $request): JsonResponse
    {
        return $this->service->index($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request): JsonResponse
    {
        return $this->service->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        return $this->service->show($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->service->destroy($id);
    }
}
