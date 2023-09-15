<?php

namespace App\Http\Filters;

use App\Enums\TaskStatus;

class TaskFilter extends Filter
{
    public function title(string $value): \Illuminate\Database\Eloquent\Builder
    {
        return $this->builder->where('title', 'like', "%$value%");
    }

    public function priority_min(int $value): \Illuminate\Database\Eloquent\Builder
    {
        return $this->builder->where('priority', '>',  $value);
    }

    public function priority_max(int $value): \Illuminate\Database\Eloquent\Builder
    {
        return $this->builder->where('priority', '<', $value);
    }

    public function status(string $value): \Illuminate\Database\Eloquent\Builder
    {
        return $this->builder->where('status', $value);
    }

    public function sort(string $value): \Illuminate\Database\Eloquent\Builder
    {
        return match($value) {
            'created_at_asc' => $this->builder->orderBy('created_at'),
            'created_at_desc' => $this->builder->orderBy('created_at', 'desc'),
            'completed_at_asc' => $this->builder->orderBy('completed_at'),
            'completed_at_desc' => $this->builder->orderBy('completed_at', 'desc'),
            'priority_asc' => $this->builder->orderBy('priority'),
            'priority_desc' => $this->builder->orderBy('priority', 'desc'),
        };
    }
}
