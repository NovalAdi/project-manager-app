<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionRoleController extends Controller
{
    public function index()
    {
        $permission = Permission::all();
        return response()->json(
            [
                'status' => true,
                'data' => $permission
            ]
        );
    }

    public function show($id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'permission not found'
                ],
                404
            );
        }

        return response()->json(
            [
                'stastus' => true,
                'data' => $permission
            ]
        );
    }


    function create(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'name.*' => 'required|unique:permissions,name',
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

        foreach ($req->input('name') as $value) {
            Permission::create(['name' => $value]);
        }

        return response()->json(
            [
                'status' => true,
                'message' => 'permission succeesfully added',
            ]
        );
    }

    public function update(Request $req, $id)
    {
        $input = $req->all();
        $permission = Permission::find($id);
        if ($permission == null) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'permission not found',
                    'data' => []
                ],
                404
            );
        }

        $validator = Validator::make($input, [
            'name' => 'required|unique:permissions,name,' . $id,
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

        $permission->update($input);
        return response()->json(
            [
                'status' => true,
                'message' => 'permission succeesfully updated',
                'data' => $permission
            ]
        );
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        if ($permission == null) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'permission not found',
                    'data' => []
                ],
                404
            );
        }

        $permission->delete();
        return response()->json(
            [
                'status' => true,
                'message' => 'permission succeesfully deleted',
                'data' => $permission
            ]
        );
    }
}
