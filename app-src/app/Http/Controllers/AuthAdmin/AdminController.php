<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show()
    {
        return view('authadmin.profile', ['user' => auth()->user()]);
    }

    public function edit()
    {
        return view('authadmin.profile-edit', ['user' => auth()->user()]);
    }

    public function showPassword()
    {
        return view('authadmin.passwords.password-edit');
    }

    public function update()
    {
        $ignore_id = auth()->user()->id;
        auth()->user()->update(request()->validate([
            'name' => 'required',
            'email' => ['required', "unique:admins,email,{$ignore_id}"]
        ]));
        return redirect()->route('auth.admin.profile');
    }

    public function updatePassword()
    {
        $data = request()->validate([
            'password' => ['required', 'confirmed']
        ]);
        $data['password'] = bcrypt($data['password']);
        auth('admin')->user()->update($data);
        return redirect()->route('auth.admin.profile');
    }
}