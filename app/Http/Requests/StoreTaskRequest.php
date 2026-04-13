<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', 'in:pending,in_progress,completed'],
            'priority'    => ['required', 'in:low,medium,high'],
            'due_date'    => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'          => 'Task title is required.',
            'title.max'               => 'Title cannot exceed 255 characters.',
            'status.in'               => 'Invalid status selected.',
            'priority.in'             => 'Invalid priority selected.',
            'due_date.after_or_equal' => 'Due date must be today or in the future.',
        ];
    }
}
