<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Wallet extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'wallets';
    protected $fillable = [
        'id',
        'balance',
        'currency',
        'user_id',
    ];

    protected $relations = [
        'user' => 'user'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
