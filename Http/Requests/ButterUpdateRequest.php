<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ButterUpdateRequest extends FormRequest
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
            'used_buffalo_cream' => 'nullable|numeric|min:0',
            'used_cow_cream' => 'nullable|numeric|min:0',
            'wastage_buffalo_cream' => 'nullable|numeric|min:0',
            'wastage_cow_cream' => 'nullable|numeric|min:0',
            'output_buffalo_butter'=> 'nullable|numeric|min:0',
            'output_cow_butter'=> 'nullable|numeric|min:0',
            'dispatch_buffalo_butter'=> 'nullable|numeric|min:0',
            'dispatch_cow_butter'=> 'nullable|numeric|min:0',
            'remaining_buffalo_butter'=> 'nullable|numeric|min:0',
            'remaining_cow_butter'=> 'nullable|numeric|min:0',
        ];
    }
}
