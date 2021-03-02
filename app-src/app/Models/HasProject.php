<?php

namespace App\Models;

trait HasProject
{
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getSharedProjectsAttribute($value)
    {
        $user = $this;
        return Project::all()->filter(function ($project) use ($user) {
            return $project->group->hasAdmin($user);
        })->diff($this->projects);
    }
}
