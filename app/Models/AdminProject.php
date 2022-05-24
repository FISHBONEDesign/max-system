<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProject extends Model
{
    protected $table = 'admin_project';

    protected $fillable = ['project_id', 'admin_id', 'owner', 'edit'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 取得專案成員的名字
     *
     * @param [type] $value
     * @return void
     */
    public function getNameAttribute($value)
    {
        return $this->admin ? $this->admin->name : '';
    }

    /**
     * 取得專案管理者的ID
     *
     * @param [type] $value
     * @return void
     */
    public function getManagerAttribute($value)
    {
        return $this->owner ? $this->admin_id : '';
    }
}
