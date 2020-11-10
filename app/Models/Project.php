<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;
use App\Models\Activity;
use Illuminate\Support\Arr;
use App\Traits\RecordsActivityTrait;

class Project extends Model
{
    use HasFactory, RecordsActivityTrait;

    protected $guarded = [];

    public function path()
    {
    	return "projects/{$this->id}" ;
    }

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(['body' => $body]);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }
}
