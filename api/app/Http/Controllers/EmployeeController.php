<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{

    public function index()
    {

    }

    public function create(EmployeeRequest $request)
    {
        $input = $request;
        dd($input);
        $employee = app(Employee::class);
        
        $employee->create([
            'full_name' => $input['full_name'],
            'code' => $input['code'],
        ]);
    }
}
