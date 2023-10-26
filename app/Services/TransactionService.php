<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Traits\ResponseMaker;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService extends BaseService
{
    use ResponseMaker;

    private CurrencyConversionService $conversion;
    public function __construct(Transaction $model, CurrencyConversionService $conversion)
    {
        parent::__construct($model);
        $this->conversion = $conversion;
    }

    public function create($request)
    {
        $wallet = Wallet::find($request['wallet_id']);

        if (!$wallet) {
            return $this->sendError('Wallet now found');
        }

        if ($request['currency'] !== $wallet->currency) {
            $request['amount'] = $this->conversion->convert($request['amount'], $request['currency'], $wallet->currency);
        }

        if ($request['transaction_type'] === 'credit' && ($wallet->balance < $request['amount'])) {
            return $this->sendError('Insufficient balance for the transaction', 400);
        }

        DB::beginTransaction();
        try {
            // debits refer to incoming money, and credits refer to outgoing money
            if ($request['transaction_type'] === 'debit') {
                $wallet->increment('balance', $request['amount']);
            } else {
                $wallet->decrement('balance', $request['amount']);
            }

            $this->model->create([
                'wallet_id' => $request['wallet_id'],
                'transaction_type' => $request['transaction_type'],
                'amount' => $request['amount'],
                'currency' => $wallet['currency'],
                'reason' => $request['reason'],
            ]);

            DB::commit();
            return $this->sendSuccess('Transaction successful');
        } catch (Exception $e) {
            Log::info('Transaction error: '.$e->getMessage());
            DB::rollBack();
            return $this->sendError('Transaction failed', 400);
        }
    }
}