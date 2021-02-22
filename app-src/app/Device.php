<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['folder_id', 'name'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function firmwares()
    {
        return $this->hasMany(Firmware::class);
    }
}
