<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json(
            [
                'status' => true,
                'data' => $user
            ]
        );
    }

    public function show($id)
    {
        $user = User::with(['tasks','projects'])->find($id);
        if (!$user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'User not found'
                ]
            );
        }

        return response()->json(
            [
                'status' => true,
                'data' => $user
            ]
        );
    }

    public function update(Request $req, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'user not found'
                ]

            );
        }

        $user->update($req->all());
        return response()->json(
            [
                'status' => true,
                'data' => $user
            ]
        );
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'user not found'
                ],
                400
            );
        }

        $user->delete($id);
        return response()->json(
            [
                'status' => true,
                'message' => 'data succcessfully deleted'
            ]
        );
    }
}
