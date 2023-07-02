<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function managers()
    {
        return $this->belongsToMany(Manager::class, 'manager_employee', 'employee_id', 'manager_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
