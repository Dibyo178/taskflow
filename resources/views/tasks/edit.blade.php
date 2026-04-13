@extends('layouts.app')
@section('title', 'Edit Task')
@section('page-title', 'Edit Task')
@section('topbar-actions')
    <a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost btn-sm">← Back</a>
@endsection

@section('content')
<div style="max-width:640px;margin:0 auto">
    <div class="card fade-up">
        <div style="padding:28px 32px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <div>
                <div style="font-family:'Syne',sans-serif;font-size:18px;font-weight:700">Edit Task</div>
                <div style="color:var(--muted);font-size:13px;margin-top:4px">Update the task details</div>
            </div>
            <span class="badge {{ $task->statusBadgeClass }}">{{ str_replace('_',' ',$task->status) }}</span>
        </div>
        <form method="POST" action="{{ route('tasks.update', $task) }}" style="padding:28px 32px">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label" for="title">Task Title <span style="color:var(--accent-2)">*</span></label>
                <input type="text" id="title" name="title" class="form-control"
                    value="{{ old('title', $task->title) }}" autofocus>
                @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                @error('description')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="pending"     {{ old('status',$task->status) === 'pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status',$task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ old('status',$task->status) === 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="priority">Priority</label>
                    <select id="priority" name="priority" class="form-control">
                        <option value="low"    {{ old('priority',$task->priority) === 'low'    ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority',$task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ old('priority',$task->priority) === 'high'   ? 'selected' : '' }}>High</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="form-control"
                    value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                @error('due_date')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px;justify-content:space-between;padding-top:20px;border-top:1px solid var(--border)">
                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        data-confirm="Delete this task permanently?">Delete Task</button>
                </form>
                <div style="display:flex;gap:10px">
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
