<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFor extends Model
{
   
    protected $fillable = [
        'task_id',
        'task_for',
    ];

    // Define relationships

    /**
     * Get the task associated with this record.
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Get the user associated with this record.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'task_for');
    }
}

