<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function owner()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

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

    public function getGroupAttribute($value)
    {
        return Group::where([
            'model_name' => self::class,
            'model_id' => $this->id
        ])->first();
    }

    public function getMemberAttribute($value)
    {
        return Member::where([
            'group_id' => $this->group->id,
        ])->get();
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

}
