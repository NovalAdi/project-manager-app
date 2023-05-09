<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        $role = Role::all();
        return response()->json(
            [
                'status' => true,
                'data' => $role
            ]
        );
    }

    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'role not found'
                ],
                404
            );
        }

        return response()->json(
            [
                'stastus' => true,
                'data' => $role
            ]
        );
    }


    function create(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:roles,name',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $role = Role::create(['name' => $input['name']]);
        return response()->json(
            [
                'status' => true,
                'message' => 'Role succeesfully added',
                'data' => $role
            ]
        );
    }

    public function update(Request $req, $id)
    {
        $input = $req->all();
        $role = Role::find($id);
        if ($role == null) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Role not found',
                    'data' => []
                ],
                404
            );
        }

        $validator = Validator::make($input, [
            'name' => 'required|unique:roles,name,' . $id,
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $role->update($input);
        return response()->json(
            [
                'status' => true,
                'message' => 'Role succeesfully updated',
                'data' => $role
            ]
        );
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role == null) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Role not found',
                    'data' => []
                ],
                404
            );
        }

        $role->delete();
        return response()->json(
            [
                'status' => true,
                'message' => 'Role succeesfully deleted',
                'data' => $role
            ]
        );
    }
}
