<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firmware extends Model
{
    protected $table = 'firmwares';
    protected $fillable = [
        'version',
        'support_version_oldest',
        'support_version_newest',
        'checksum',
        'version_log',
        'path'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
