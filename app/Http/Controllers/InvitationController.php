<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Invitation;
use App\Models\Manager;
use App\Models\Notif;
use App\Models\Project;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    public function listEmployee($id)
    {
        if (!Employee::find($id)) {
            return response()->json([
                'status' => false,
                'message' => 'employee not found'
            ]);
        }
        $invitation = Invitation::where('employee_id', '=', $id)->get();
        return response()->json([
            'status' => true,
            'data' => $invitation
        ]);
    }

    public function listManager($id)
    {
        $manager = Manager::find($id);
        $projects = Project::where('manager_id', '=', $manager->id)->get()->toArray();

        $invitations = [];

        foreach ($projects as $key => $value) {
            $invitation = Invitation::where('project_id', '=', $value['id'])->get()->toArray();
            foreach ($invitation as $key2 => $value2) {
                $invitations[] = $value2;
            }
        }

        return response()->json([
            'status' => true,
            'data' => $invitations
        ]);;
    }

    public function create(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'project_id' => 'required',
            'employee_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ],400);
        }

        $project = Project::find($input['project_id']);

        $manager = Manager::find($project->manager_id);

        $manager->employees()->attach($input['employee_id']);

        // return dd($manager);

        $invitation = Invitation::create($input);
        return response()->json([
            'status' => true,
            'data' => $invitation
        ]);
    }

    public function update(Request $req, $id)
    {
        $invitation = Invitation::find($id);
        if (!$invitation) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'invitation not found'
                ],404
            );
        }

        $input = $req->all();

        $project = Project::find($invitation->project_id);
        $manager = Manager::find($project->manager_id);
        if ($input['status'] == 'accepted') {
            $manager->employees()->sync($invitation->employee_id);
            $notif = Notif::where('invitation_id', '=', $invitation->id)->first();
            $notif->delete();
        }

        $invitation->update($input);
        return response()->json([
            'status' => true,
            'data' => $invitation
        ]);
    }

    public function delete($id)
    {
        $invitation = Invitation::find($id);
        if (!$invitation) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'invitation not found'
                ],404
            );
        }
        $invitation->delete($id);
        return response()->json([
            'status' => true,
            'data' => 'data successfully deleted'
        ]);
    }
}
