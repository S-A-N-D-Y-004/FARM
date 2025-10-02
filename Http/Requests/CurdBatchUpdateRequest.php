<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurdBatchUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            // 'name' => 'required|integer|exists:curdbatch_name,id',
            'whole_buffalo_milk' => 'nullable|numeric',
            'skimmed_buffalo_milk' => 'nullable|numeric',
            'total_buffalo_milk' => 'nullable|numeric',
            'total_cow_milk' => 'nullable|numeric',
            'skimmed_cow_milk' => 'nullable|numeric',
            'skimmed_milk_provider' => 'nullable|numeric',
            'one_kg' => 'nullable|integer',
            'five_kg' => 'nullable|integer',
            'ten_kg' => 'nullable|integer', 
        ];
    }
}
