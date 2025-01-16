<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account', 'password', 'email', 'name', 'email_verified_at',
        'cellphone', 'interest', 'url', 'info', 'club',
        'birthday', 'times', 'administration', 'ip_address',
        'status', 'remember_token',
        'avatar_filename', 'avatar_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }
}