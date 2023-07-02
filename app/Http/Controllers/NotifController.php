<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\User;
use Illuminate\Http\Request;

class NotifController extends Controller
{
    public function getForEmployee($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'employee not found'
            ]);
        }

        $notifTo = $user->to->toArray();
        $notifToArr = array_map(function($notif) {
            $notif['from_user'] = User::find($notif['from']);
            $notif['from_user']['image'] = url('uploads/users/' . $notif['from_user']['image']);
            return $notif;
        }, $notifTo);

        return response()->json(
            [
                'status' => true,
                'data' => $notifToArr
            ]
        );
    }
}
