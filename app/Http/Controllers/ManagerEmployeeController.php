<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManagerEmployeeController extends Controller
{
    public function create(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'employee_id' => 'required',
            'manager_id' => 'required'
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

        $employee_ids = [];

        foreach ($input['employee_id'] as $value) {
            $employee = Employee::find($value);
            if (!$employee) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'employee not found'
                    ],
                    404
                );
            } else {
                $employee_ids[] = $value;
            }
        }

        $manager = Manager::find($input['manager_id']);
        if (!$manager) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'manager not found'
                ],
                404
            );
        }

        $manager->participants()->sync($employee_ids);

        $data = DB::table('manager_employees')->where('manager_id', '=', $manager->id)->get();

        return response()->json(
            [
                'status' => true,
                'message' => 'data succeesfully created',
                'data' => $data
            ]
        );
    }
}
