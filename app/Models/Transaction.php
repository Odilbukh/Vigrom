<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'id',
        'amount',
        'currency',
        'reason',
        'transaction_type',
        'wallet_id',
    ];

    protected $relations = [
        'wallet' => 'wallet'
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
