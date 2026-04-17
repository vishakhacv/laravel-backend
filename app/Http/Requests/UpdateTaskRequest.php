<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'status' => 'nullable|in:TODO,IN_PROGRESS,DONE,OVERDUE',
        ];

        // Admin can update all fields
        if ($this->user()->isAdmin()) {
            $rules['title'] = 'nullable|string|max:255';
            $rules['description'] = 'nullable|string';
            $rules['priority'] = 'nullable|in:LOW,MEDIUM,HIGH';
            $rules['due_date'] = 'nullable|date';
            $rules['project_id'] = 'nullable|exists:projects,id';
            $rules['assigned_to'] = 'nullable|exists:users,id';
        }

        return $rules;
    }
}
