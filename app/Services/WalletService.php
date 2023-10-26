<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService extends BaseService
{
    public function __construct(Wallet $model)
    {
        parent::__construct($model);
    }
}