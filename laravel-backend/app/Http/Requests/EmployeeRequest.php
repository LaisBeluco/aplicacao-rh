<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class EmployeeRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|min:10',
            'full_name' => 'required|max:255',
            'user_name' => 'required|max:55',
            'document' => 'required|min:11|max:11',
            'date_birth' => 'required|numeric',
            'mother_name' => 'required|max:255',
            'father_name' => 'max:255',
            'role' => 'required|max:55'
        ]; 
    }
}