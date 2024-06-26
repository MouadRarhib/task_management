<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'pkid_task';
    protected $guarded = []; // Ensure other fields are fillable

    protected $fillable = [
        'name',
        'description',
        'fkid_status',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'fkid_status', 'pkid_status');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'fkid_task', 'pkid_task');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'fkid_task', 'pkid_task');
    }
}

