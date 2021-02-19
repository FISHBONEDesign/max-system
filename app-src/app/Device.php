<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['name', 'level'];

    public function firmwares()
    {
        return $this->hasMany(Firmware::class);
    }
}
