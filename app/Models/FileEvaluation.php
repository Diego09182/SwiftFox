<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileEvaluation extends Model
{
    use HasFactory;

    protected $table = 'file_evaluations';

    protected $fillable = ['file_id', 'user_id', 'evaluation'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
