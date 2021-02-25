<?php

namespace App;

use App\Models\Admin;
use App\Models\Device;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function owner()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function getContentsAttribute($value)
    {
        return $this->folders->concat($this->devices);
    }
}
