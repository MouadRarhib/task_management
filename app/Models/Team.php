<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'pkid_team';

    protected $fillable = [
        'name',
        'fkid_project',
        'fkid_user',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'fkid_project', 'pkid_project');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fkid_user', 'pkid_user');
    }
}
