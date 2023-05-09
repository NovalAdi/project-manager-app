<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
            'role' => 'required|exists:roles,name'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors(),
                    'data' => []
                ]
            );
        }

        $passwordHash = Hash::make($req->input('password'));
        $input = [
            'username' => $req->input('username'),
            'email' => $req->input('email'),
            'password' => $passwordHash
        ];

        $user = User::create($input);

        $token = $user->createToken('authToken')->plainTextToken;

        $user->assignRole($req->input('role'));

        $response = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->getRoleNames()->first(),
            'token' => $token
        ];

        return response()->json(
            [
                'status' => true,
                'message' => 'Register succeed',
                'data' => $response
            ]
        );
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
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            $data = [
                'token' => $token,
                'user' => $user
            ];
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Login succeed',
                    'data' => $data
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Login failed',
                    'data' => []
                ],
                401
            );
        }
    }

    public function logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => true,
                'message' => 'Logout succeed',
            ]
        );
    }
}
