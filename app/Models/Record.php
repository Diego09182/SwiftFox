<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = ['opinion_id', 'user_id'];

    public function opinion()
    {
        return $this->belongsTo(Opinion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
