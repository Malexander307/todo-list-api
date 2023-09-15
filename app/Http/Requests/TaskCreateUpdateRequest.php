<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Validation\Rule;

class TaskCreateUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'priority' => ['required', 'numeric', 'between:1,5'],
            'title' => ['max:255', 'required'],
            'description' => ['nullable'],
            'parent_id' => ['nullable', 'exists:tasks,id']
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'user_id' => \Auth::id(),
            'status' => TaskStatus::TODO->value
        ]);
    }
}
