<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'priority',
        'title',
        'description',
        'completed_at',
        'parent_id',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'parent_id',
        'user_id'
    ];

    protected $casts = [
        'status' => TaskStatus::class
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }

}
