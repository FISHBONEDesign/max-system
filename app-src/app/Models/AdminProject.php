<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProject extends Model
{
    protected $table = 'admin_project';

    protected $fillable = ['project_id', 'admin_id', 'owner', 'edit'];

    public function user()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getNameAttribute($value)
    {
        return $this->user ? $this->user->name : '';
    }
}
