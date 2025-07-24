<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrizeRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'status',
        'note',
        'user_id',
        'prize_id',
        'shipping_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
