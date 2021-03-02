<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'group_members';

    protected $fillable = ['admin_id', 'edit'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function getUserIdAttribute($value)
    {
        return $this->user ? $this->user->id : null;
    }

    public function getNameAttribute($value)
    {
        return $this->user ? $this->user->name : '';
    }

    public function getEditAttribute($value)
    {
        return $value ? 'true' : 'false';
    }
}
