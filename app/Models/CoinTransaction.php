<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'coins',
        'type',
        'status',
        'payment_method',
        'transaction_id',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
