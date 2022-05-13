<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    /**
     * 列出所有使用者
     *
     * @return void
     */
    public function index()
    {
        $users = Admin::all();
        $roles = Role::all();
        return view('editusers.index', compact('users', 'roles'));
    }

    public function update(Admin $users)
    {
        $users->update([
            'role' => request()->input('userPermission')
        ]);
        $roles = Role::all();
        return redirect()->route('admin.users.index', compact('users', 'roles'));
    }
}
