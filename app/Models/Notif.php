<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invitation()
    {
        return $this->hasOne(Invitation::class);
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'to');
    }
}
