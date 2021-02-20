<?php

namespace App;

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

    public function getDevicesAttribute($value)
    {
        $folder = $this->folders()->where('parent_id', 0)->first();
        if ($folder) return $folder->devices;
        else return collect();
    }

    public function getContentsAttribute($value)
    {
        return $this->folders()->where('parent_id', 0)->get()->map(function ($folder) {
            $folder->type = 'folder';
            return $folder;
        })->merge($this->devices->map(function ($device) {
            $device->type = 'device';
            return $device;
        }));
    }
}
