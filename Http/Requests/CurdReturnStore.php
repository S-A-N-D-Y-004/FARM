<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurdReturnStore extends FormRequest
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
            'curd_standard_1kg' => 'nullable|numeric|min:0',
            'curd_standard_5kg' => 'nullable|numeric|min:0',
            'curd_standard_10kg' => 'nullable|numeric|min:0',
            'curd_standard_total' => 'nullable|numeric|min:0',
            'curd_double_1kg'=> 'nullable|numeric|min:0',
            'curd_double_5kg'=> 'nullable|numeric|min:0',
            'curd_double_10kg'=> 'nullable|numeric|min:0',
            'curd_double_total'=> 'nullable|numeric|min:0',
            'curd_toned_1kg'=> 'nullable|numeric|min:0',
            'curd_toned_5kg'=> 'nullable|numeric|min:0',
            'curd_toned_10kg'=> 'nullable|numeric|min:0',
            'curd_toned_total'=> 'nullable|numeric|min:0',
        ];
    }
}
