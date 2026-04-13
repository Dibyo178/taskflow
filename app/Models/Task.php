<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // ── Scopes ──────────────────────────────────────────
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('due_date')
                     ->where('due_date', '<', now()->toDateString())
                     ->whereNot('status', 'completed');
    }

    // ── Accessors ───────────────────────────────────────
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'badge-pending',
            'in_progress' => 'badge-in-progress',
            'completed'   => 'badge-completed',
            default       => 'badge-pending',
        };
    }

    public function getPriorityBadgeClassAttribute(): string
    {
        return match($this->priority) {
            'low'    => 'priority-low',
            'medium' => 'priority-medium',
            'high'   => 'priority-high',
            default  => 'priority-medium',
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== 'completed';
    }
}
