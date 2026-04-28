<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'scope' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            // Honeypot field — must be empty.
            'website' => ['nullable', 'prohibited'],
            // Time-trap — form must take at least 2 seconds to fill.
            'started_at' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'website.prohibited' => 'Bot detected.',
        ];
    }
}
