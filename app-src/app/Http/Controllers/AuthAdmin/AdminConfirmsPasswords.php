<?php

namespace App\Http\Controllers\AuthAdmin;

use Illuminate\Foundation\Auth\ConfirmsPasswords;

trait AdminConfirmsPasswords{
    use ConfirmsPasswords;

    /**
     * Display the password confirmation view.
     *
     * @return \Illuminate\Http\Response
     */
    public function showConfirmForm()
    {
        return view('authadmin.passwords.confirm');
    }
}
