<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = [
        'prize',
        'price',
        'quantity',
        'image',
    ];

    public function redemptions()
    {
        return $this->hasMany(PrizeRedemption::class);
    }
}
