<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
        return view('editusers.index', compact('users'));
    }

    public function update(Admin $users)
    {
        $users->update([
            'role' => request()->input('userPermission')
        ]);
        return redirect()->route('admin.users.index', $users);
    }
}
