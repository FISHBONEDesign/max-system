<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function admin()
    {
        return $this->belongsToMany(Admin::class);
    }

    public function adminProject()
    {
        return $this->hasMany(AdminProject::class);
    }

    public function getContentsAttribute($value)
    {
        return $this->folders->concat($this->devices);
    }

    /**
     * 判斷使用是否為專案管理員
     *
     * @param [type] $value
     * @return boolean
     */
    public function isProjectManager($value)
    {
        return $this->adminProject->where('admin_id', $value)->first()->owner;
    }

    public function hasAdmin(Admin $user)
    {
        return !!$this->adminProject->pluck('admin')->pluck('id')->contains($user->id);
    }

    public function canAdminEdit(Admin $user)
    {
        return $this->hasAdmin($user) ? $this->adminProject()->where(['admin_id' => $user->id])->first()->edit : false;
    }
}
