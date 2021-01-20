<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    /**
     * Login api
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $uset = Auth::user();
            $token = $uset->createToken(config('app.name'))->accessToken;
            return response()->json(['status' => 'success', 'data' => ['token' => $token]], 200);
        } else {
            return response()->json(['status' => 'failure', 'message' => 'Unauthenticated.'], 401);
        }
    }

    /**
     * Register api
     */
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_c' => ['required', 'string', 'same:password']
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'failure', 'message' => ['errors' => $validated->errors()]], 400);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return $this->login($request);
    }

    /**
     * user profile for testing
     */
    public function profile(Request $request)
    {
        return Auth::user();
    }
}
