<?php

namespace App\Services;

use App\Traits\ResponseMaker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseService
{
    use ResponseMaker;

    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index($request)
    {
        $result = $this->model->queryFilter($request);

        return $this->sendResponse($result['result'], pagination: ['page' => $request['page'], 'size' => $request['size'], 'total' => $result['total']]);
    }

    public function store($request)
    {
        return $this->model->create($request);
    }

    public function show(int $id)
    {
        $result = $this->model->find($id);

        if (is_null($result)) {
            return $this->sendError();
        }

        if ($this->model->getTable() === 'wallets') {
            $result->refund_sum = $this->getRefundSum($id);
        }

        return $this->sendResponse($result, 'Model retrieved successfully');
    }


    public function destroy(int $id)
    {
        $result = $this->model->findOrFail($id);
        $result->delete();

        return $this->sendSuccess('Model deleted successfully');
    }

    private function getRefundSum($walletId)
    {
        // it makes SQL query like this:
        //"SELECT SUM(amount) FROM transactions WHERE wallet_id = :walletId AND reason = 'refund' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)"

        return DB::table('transactions')
            ->where('wallet_id', $walletId)
            ->where('reason', 'refund')
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('amount');
    }
}