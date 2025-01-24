<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|max:10',
            'full_name' => 'required|max:255',
            'user_name' => 'required|max:55',
            'document' => [
                'required',
                'min:11',
                'max:11',
                Rule::unique('employees', 'document')
                    ->whereNull('deleted_at')
                    ->ignore($this->id),
            ],
            'date_birth' => 'required|date',
            'mother_name' => 'required|max:255',
            'father_name' => 'max:255',
            'role' => 'required|max:55'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'document' => preg_replace('/[^\d]/', '', $this->request->get('document'))
        ]);
    }
}
