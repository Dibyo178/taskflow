@extends('layouts.app')
@section('title', 'New Task')
@section('page-title', 'Create Task')
@section('topbar-actions')
    <a href="{{ route('tasks.index') }}" class="btn btn-ghost btn-sm">← Back</a>
@endsection

@section('content')
<div style="max-width:640px;margin:0 auto">
    <div class="card fade-up">
        <div style="padding:28px 32px;border-bottom:1px solid var(--border)">
            <div style="font-family:'Syne',sans-serif;font-size:18px;font-weight:700">New Task</div>
            <div style="color:var(--muted);font-size:13px;margin-top:4px">Fill in the details to create a task</div>
        </div>
        <form method="POST" action="{{ route('tasks.store') }}" style="padding:28px 32px">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Task Title <span style="color:var(--accent-2)">*</span></label>
                <input type="text" id="title" name="title" class="form-control"
                    placeholder="e.g. Design new landing page"
                    value="{{ old('title') }}" autofocus>
                @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control"
                    placeholder="Add any details or notes..." rows="4">{{ old('description') }}</textarea>
                @error('description')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color:var(--accent-2)">*</span></label>
                    <select id="status" name="status" class="form-control">
                        <option value="pending"     {{ old('status','pending') === 'pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ old('status') === 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="priority">Priority <span style="color:var(--accent-2)">*</span></label>
                    <select id="priority" name="priority" class="form-control">
                        <option value="low"    {{ old('priority') === 'low'              ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority','medium') === 'medium'  ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ old('priority') === 'high'             ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="form-control"
                    value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}">
                @error('due_date')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;padding-top:20px;border-top:1px solid var(--border)">
                <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">＋ Create Task</button>
            </div>
        </form>
    </div>
</div>
@endsection
