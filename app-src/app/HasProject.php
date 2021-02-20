<?php

namespace App;

trait HasProject
{
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }
}
