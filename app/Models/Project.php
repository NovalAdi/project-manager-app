<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function invitation()
    {
        return $this->hasMany(Invitation::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Employee::class, 'invitations', 'project_id', 'employee_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskTotal()
    {
       return $this->tasks()->count();
    }
    public function taskDone()
    {
       return $this->tasks()->where('status', 'done')->count();
    }

    public function taskUndone()
    {
       return $this->tasks()->where('status', 'undone')->count();
    }

    public function taskPending()
    {
       return $this->tasks()->where('status', 'pending')->count();
    }


}
