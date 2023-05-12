<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function index()
    {
        $manager = Manager::all();
        return response()->json(
            [
                'stastus' => true,
                'data' => $manager
            ]
        );
    }

    public function delete($id)
    {
        $manager = Manager::find($id);
        if (!$manager) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'manager not found'
                ],
                400
            );
        }

        $manager->delete($id);
        return response()->json(
            [
                'status' => true,
                'message' => 'data succcessfully deleted'
            ]
        );
    }
}
