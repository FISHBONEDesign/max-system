<?php

namespace App\Models;

trait HasProject
{
    /**
     * 所有專案
     *
     * @return void
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * 取得我的專案
     *
     * @param [type] $value
     * @return void
     */
    public function getMyProjectsAttribute($value)
    {
        # code...
    }

    /**
     * 取得共同協作的專案
     *
     * @param [type] $value
     * @return void
     */
    public function getSharedProjectsAttribute($value)
    {
        $user = $this;

        return Project::all()->filter(function ($project) use ($user) {
            return $project->hasAdmin($user);
        })->diff($this->projects);
    }
}
