<?php

namespace App\Http\Requests\AppHumanResources\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'attendance' => 'required|mimes:xlsx,xls'
        ];
    }
     /**
     * Custom message for validation
     *
     * @return array
     */

    public function messages()
    {
        return [
            'attendance.required' => 'Excel file is required!'
        ];
    }
}
