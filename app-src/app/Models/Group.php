<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'model_name', 'model_id'];

    public function getModelAttribute($value)
    {
        return class_basename($this->model_name);
    }

    public function getObjectAttribute($value)
    {
        return $this->model_name::find($this->model_id)->name;
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function hasAdmin(Admin $user)
    {
        return !!$this->members->pluck('user')->pluck('id')->contains($user->id);
    }

    public function canAdminEdit(Admin $user)
    {
        return $this->hasAdmin($user) ? $this->members()->where(['admin_id' => $user->id])->first()->edit : false;
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'model_id');
    }
}
