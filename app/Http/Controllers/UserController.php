<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

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

    public function showManager($id)
    {
        $user = User::with(['managers_project'])->find($id);
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

    public function showEmployee($id)
    {
        $user = User::with(['tasks', 'employees_project'])->find($id);
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
        $input = $req->all();

        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'user not found'
                ]

            );
        }

        $validator = Validator::make($req->all(), [
            'image' => 'nullable|image|mimes:png,jpg,jpeg|'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors(),
                ],
                400
            );
        }
        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $path = 'uploads/users/';
            if ($user->image != 'default_pp.png' && $user->image != null) {
                if (File::exists($path . $user->image)) {
                    File::delete($path . $user->image);
                }
            }

            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $img = Image::make($file->getRealPath());
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path . $fileName);
            $input['image'] = $fileName;
        }

        $user->update($input);
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

        $path = 'uploads/users/';
        if ($user->image != 'default_pp.png' && $user->image != null) {
            if (File::exists($path . $user->image)) {
                File::delete($path . $user->image);
            }
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
