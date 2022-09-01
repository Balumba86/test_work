<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'reason',
        'operation_type',
        'amount'
    ];

    public function wallet()
    {
        return $this->belongsTo(UserWallet::class);
    }
}
