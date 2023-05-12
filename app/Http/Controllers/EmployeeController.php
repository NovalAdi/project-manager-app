<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::all();
        return response()->json(
            [
                'stastus' => true,
                'data' => $employee
            ]
        );
    }

    public function delete($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'employee not found'
                ],
                400
            );
        }

        $employee->delete($id);
        return response()->json(
            [
                'status' => true,
                'message' => 'data succcessfully deleted'
            ]
        );
    }
}
