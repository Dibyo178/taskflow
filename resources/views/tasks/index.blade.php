@extends('layouts.app')
@section('title', 'All Tasks')
@section('page-title', 'Dashboard')

@section('content')

<div class="stats-grid fade-up">
    <div class="stat-card total">
        <div class="stat-value">{{ $counts['total'] }}</div>
        <div class="stat-label">Total Tasks</div>
    </div>
    <div class="stat-card pending">
        <div class="stat-value" style="color:var(--pending)">{{ $counts['pending'] }}</div>
        <div class="stat-label">Pending</div>
    </div>
    <div class="stat-card progress">
        <div class="stat-value" style="color:var(--progress)">{{ $counts['in_progress'] }}</div>
        <div class="stat-label">In Progress</div>
    </div>
    <div class="stat-card done">
        <div class="stat-value" style="color:var(--done)">{{ $counts['completed'] }}</div>
        <div class="stat-label">Completed</div>
    </div>
    <div class="stat-card overdue">
        <div class="stat-value" style="color:var(--accent-2)">{{ $counts['overdue'] }}</div>
        <div class="stat-label">Overdue</div>
    </div>
</div>

<div class="filter-bar fade-up" style="animation-delay:.05s">
    <form method="GET" action="{{ route('tasks.index') }}">
        <input type="text" name="search" class="form-control" style="width:220px"
            placeholder="Search tasks..." value="{{ request('search') }}">

        <select name="status" class="form-control" style="width:150px">
            <option value="all"        {{ request('status','all') === 'all'        ? 'selected' : '' }}>All Status</option>
            <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
            <option value="in_progress"{{ request('status') === 'in_progress'? 'selected' : '' }}>In Progress</option>
            <option value="completed"  {{ request('status') === 'completed'  ? 'selected' : '' }}>Completed</option>
        </select>

        <select name="priority" class="form-control" style="width:150px">
            <option value="all"   {{ request('priority','all') === 'all'   ? 'selected' : '' }}>All Priority</option>
            <option value="high"  {{ request('priority') === 'high'   ? 'selected' : '' }}>High</option>
            <option value="medium"{{ request('priority') === 'medium'  ? 'selected' : '' }}>Medium</option>
            <option value="low"   {{ request('priority') === 'low'    ? 'selected' : '' }}>Low</option>
        </select>

        <button type="submit" class="btn btn-ghost btn-sm">Filter</button>

        @if(request()->hasAny(['search','status','priority']))
            <a href="{{ route('tasks.index') }}" class="btn btn-ghost btn-sm">✕ Clear</a>
        @endif
    </form>
    <span style="font-size:12px;color:var(--muted);margin-left:auto">
        {{ $tasks->total() }} task{{ $tasks->total() !== 1 ? 's' : '' }} found
    </span>
</div>

@if($tasks->count())
    <div class="tasks-grid">
        @foreach($tasks as $i => $task)
        <div class="task-card fade-up" style="animation-delay:{{ $i * 0.04 }}s">
            <div class="task-card-header">
                <a href="{{ route('tasks.show', $task) }}" class="task-title">{{ $task->title }}</a>
            </div>

            @if($task->description)
                <p class="task-desc">{{ Str::limit($task->description, 90) }}</p>
            @endif

            <div class="task-meta">
                <span class="badge {{ $task->statusBadgeClass }}">
                    {{ str_replace('_', ' ', $task->status) }}
                </span>
                <span class="badge {{ $task->priorityBadgeClass }}">{{ $task->priority }}</span>
            </div>

            <div class="task-footer">
                <span class="task-date {{ $task->isOverdue ? 'overdue' : '' }}">
                    @if($task->due_date)
                        {{ $task->isOverdue ? '⚠' : '📅' }}
                        {{ $task->due_date->format('M d, Y') }}
                        {{ $task->isOverdue ? '(overdue)' : '' }}
                    @else
                        <span style="color:var(--muted)">No due date</span>
                    @endif
                </span>
                <div class="task-actions">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost btn-sm">✎</a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            data-confirm="Delete this task?">✕</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($tasks->hasPages())
        <div class="pagination">
            @if($tasks->onFirstPage())
                <span class="page-link" style="opacity:.4">‹</span>
            @else
                <a href="{{ $tasks->previousPageUrl() }}" class="page-link">‹</a>
            @endif

            @foreach($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $tasks->currentPage() === $page ? 'active' : '' }}">{{ $page }}</a>
            @endforeach

            @if($tasks->hasMorePages())
                <a href="{{ $tasks->nextPageUrl() }}" class="page-link">›</a>
            @else
                <span class="page-link" style="opacity:.4">›</span>
            @endif
        </div>
    @endif

@else
    <div class="card empty-state fade-up">
        <div class="empty-icon">◈</div>
        <div class="empty-title">No tasks found</div>
        <div class="empty-desc">
            @if(request()->hasAny(['search','status','priority']))
                No tasks match your filters.
            @else
                You haven't created any tasks yet.
            @endif
        </div>
        @if(request()->hasAny(['search','status','priority']))
            <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Clear Filters</a>
        @else
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">＋ Create First Task</a>
        @endif
    </div>
@endif

@endsection
