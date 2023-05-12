<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebAuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'username' => 'required',
            'password' => 'required',
        ],);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors(),
                    'data' => []
                ],
                400
            );
        }

        $loginType = filter_var($req->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $req->input('username'),
            'password' => $req->input('password')
        ];

        if (auth()->attempt($credentials)) {
            return redirect()->intended('/dashboard')->with('success', 'Success login');
        }
        return redirect('login')->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        session()->flush();
        auth()->logout();
        return redirect()->route('login.view');
    }
}
