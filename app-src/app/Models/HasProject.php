<?php

namespace App\Models;

trait HasProject
{
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }
}
