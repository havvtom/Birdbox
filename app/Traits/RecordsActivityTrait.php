<?php

namespace App\Traits;

use App\MOdels\Activity;
use Illuminate\Support\Arr;

trait RecordsActivityTrait {

	public $old = [];

    public static function bootRecordsActivityTrait()
    {
    	static:: updating (function ($model) {
    		$model->old = $model->getOriginal();
    	});

    } 

	public function recordActivity($description)
    {
        return $this->activity()->create([
        	'user_id' => $this->project->owner->id ?? $this->owner->id,
            'description' => $description, 
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'changes' => $this->activityChanges()
        ]);
    }

    protected function activityChanges()
    {
        if($this->wasChanged()) {
           return [
                'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
