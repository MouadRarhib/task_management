<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'pkid_project';

    protected $fillable = [
        'name',
        'created_date',
        'end_date',
        'fkid_task',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'fkid_task', 'pkid_task');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'fkid_project', 'pkid_project');
    }
}
