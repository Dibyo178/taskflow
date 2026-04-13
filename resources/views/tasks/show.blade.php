@extends('layouts.app')
@section('title', $task->title)
@section('page-title', 'Task Detail')
@section('topbar-actions')
    <a href="{{ route('tasks.index') }}" class="btn btn-ghost btn-sm">← All Tasks</a>
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost btn-sm">✎ Edit</a>
@endsection

@section('content')
<div class="card fade-up">
    <div class="detail-grid">
        <div class="detail-body">
            <h1 style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;line-height:1.3;margin-bottom:12px">
                {{ $task->title }}
            </h1>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px">
                <span class="badge {{ $task->statusBadgeClass }}">{{ str_replace('_',' ',$task->status) }}</span>
                <span class="badge {{ $task->priorityBadgeClass }}">{{ $task->priority }} priority</span>
                @if($task->isOverdue)
                    <span class="badge" style="background:rgba(255,101,132,.14);color:var(--accent-2)">⚠ Overdue</span>
                @endif
            </div>

            <div class="detail-label">Description</div>
            @if($task->description)
                <p style="color:var(--muted-2);line-height:1.7;font-size:14px">{{ $task->description }}</p>
            @else
                <p style="color:var(--muted);font-style:italic;font-size:14px">No description provided.</p>
            @endif

            <div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
                <div class="detail-label" style="margin-bottom:12px">Quick Status Update</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    @foreach(['pending','in_progress','completed'] as $s)
                        <form method="POST" action="{{ route('tasks.update-status', $task) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="{{ $s }}">
                            <button type="submit" class="btn btn-sm {{ $task->status === $s ? 'btn-primary' : 'btn-ghost' }}">
                                {{ str_replace('_',' ',ucfirst($s)) }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="detail-sidebar">
            <div>
                <div class="detail-label">Due Date</div>
                <div style="{{ $task->isOverdue ? 'color:var(--accent-2)' : '' }}">
                    @if($task->due_date)
                        {{ $task->due_date->format('F d, Y') }}<br>
                        <small style="font-size:12px;color:var(--muted)">{{ $task->due_date->diffForHumans() }}</small>
                    @else
                        <span style="color:var(--muted)">—</span>
                    @endif
                </div>
            </div>
            <div>
                <div class="detail-label">Created</div>
                <div style="color:var(--muted-2);font-size:14px">
                    {{ $task->created_at->format('M d, Y') }}<br>
                    <small style="color:var(--muted)">{{ $task->created_at->diffForHumans() }}</small>
                </div>
            </div>
            <div>
                <div class="detail-label">Last Updated</div>
                <div style="color:var(--muted-2);font-size:14px">
                    {{ $task->updated_at->format('M d, Y') }}<br>
                    <small style="color:var(--muted)">{{ $task->updated_at->diffForHumans() }}</small>
                </div>
            </div>
            <div style="margin-top:auto;padding-top:20px;border-top:1px solid var(--border);display:flex;flex-direction:column;gap:8px">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost btn-sm" style="justify-content:center">✎ Edit Task</a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        style="width:100%;justify-content:center"
                        data-confirm="Delete this task permanently?">✕ Delete Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
