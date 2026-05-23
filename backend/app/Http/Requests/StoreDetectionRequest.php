<?php

namespace App\Http\Requests;

use App\Enums\Severity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDetectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Detection results are dummy data, so the client may post them directly.
     * Only the disease name is required; the rest fall back to sensible
     * defaults in the controller.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'disease_name' => ['required', 'string', 'max:255'],
            'severity' => ['nullable', Rule::enum(Severity::class)],
            'confidence' => ['nullable', 'integer', 'min:0', 'max:100'],
            'detected_area' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'], // KB => 5 MB
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
