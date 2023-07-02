<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:8',
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
        $inputuser = [
            'username' => $req->input('username'),
            'email' => $req->input('email'),
            'password' => $passwordHash
        ];

        $user = User::create($inputuser);

        $token = $user->createToken('authToken')->plainTextToken;

        $user->assignRole($req->input('role'));
        $user->image = url('uploads/users/default_pp.png');

        if ($input['role'] == 'manager') {
            Manager::create(
                [
                    'user_id' => $user->id
                ]
            );
        } else {
            Employee::create(
                [
                    'user_id' => $user->id
                ]
            );
        }

        $data = [
            'token' => $token,
            'user' => $user,
        ];

        return response()->json(
            [
                'status' => true,
                'message' => 'Register succeed',
                'data' => $data
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

            $user->image = url('uploads/users/'. $user->image);
            $data = [
                'token' => $token,
                'user' => $user,
                'role' => $user->getRoleNames()->first(),
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
