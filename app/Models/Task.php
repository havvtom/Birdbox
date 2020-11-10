<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Traits\RecordsActivityTrait;
use Illuminate\Support\Arr;

class Task extends Model
{
    use HasFactory, RecordsActivityTrait;

    protected $guarded = [];

    protected $casts = [
      'completed' => 'boolean',
    ];

    protected $touches = ['project'];

    public function project()
    {
    	return $this->belongsTo(Project::class);
    }

    public function path()
    {
    	return $this->project->path().'/tasks/'.$this->id;
    }

    public function complete()
    {
        $this->update([
            'completed' => true
        ]);
        
        $this->recordActivity('task_completed');
    }

    public function incomplete()
    {
        $this->update([
            'completed' => false
        ]);

        $this->recordActivity('task_incomplete');
    }

    
}
