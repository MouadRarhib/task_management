<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'pkid_user';

    protected $fillable = [
        'full_name',
        'role',
        'email',
        'password',
        'fkid_task',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'fkid_task', 'pkid_task');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'fkid_user', 'pkid_user');
    }
}
