<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firmware extends Model
{
    protected $table = 'firmwares';
    protected $fillable = ['version', 'checksum', 'path'];
}
