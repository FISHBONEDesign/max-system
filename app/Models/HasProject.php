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
        return $this->adminProject->where('owner', 1)->all();
    }

    /**
     * 取得共同協作的專案
     *
     * @param [type] $value
     * @return void
     */
    public function getSharedProjectsAttribute($value)
    {
        return $this->adminProject->where('owner', 0)->all();
    }
}
