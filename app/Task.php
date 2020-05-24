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
        'total_elapsed_time',
    ];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeGroupedTasksByStatus($query, $month): \Illuminate\Database\Eloquent\Builder
    {
        return $query
            ->select(\DB::raw("count(id) as total"), 'status')
            ->whereMonth('started_at', '=', $month)
            ->whereMonth('finished_at', '=', $month)
            ->groupBy('status');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $month
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupedTasksByUsers($query, string $month): \Illuminate\Database\Eloquent\Builder
    {
        return $query
            ->with('user:id,name')
            ->select(\DB::raw("count(id) as total"), 'user_id')
            ->whereMonth('started_at', '=', $month)
            ->whereMonth('finished_at', '=', $month)
            ->groupBy('user_id');
    }
}
