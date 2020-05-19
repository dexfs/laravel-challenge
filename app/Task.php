<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'user_tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'started_at',
        'finished_at',
        'user_id',
        'total_elapsed_time'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
