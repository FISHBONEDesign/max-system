<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Folder extends Model
{
    protected $fillable = ['project_id', 'parent_id', 'name'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function folders()
    {
        return $this->hasMany(self::class, 'parent_id')->where('project_id', $this->project_id);
    }

    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id')->where('project_id', $this->project_id);
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'folder_device');
    }

    public function getContentsAttribute($value)
    {
        return $this->folders->map(function ($folder) {
            $folder->type = 'folder';
            return $folder;
        })->merge($this->devices->map(function ($device) {
            $device->type = 'device';
            return $device;
        }));
    }
}
