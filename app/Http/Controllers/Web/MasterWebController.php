<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Notif;
use App\Models\Task;
use Illuminate\Http\Request;

class MasterWebController extends Controller
{
    public function acccept($id)
    {
        $notif = Notif::find($id);
        if ($notif->invitation_id != null) {
            $invitation = Invitation::find($notif->invitation_id);
            $invitation->update([
                'status' => 'accepted'
            ]);
        }
        $notif->delete();
        return redirect()->route('dashboard');
    }

    public function decline($id)
    {
        $notif = Notif::find($id);
        if ($notif->invitation_id != null) {
            $invitation = Invitation::find($notif->invitation_id);
            $invitation->delete();
        }
        $notif->delete();
        return redirect()->route('dashboard');
    }
}
