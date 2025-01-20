<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = DB::table('employees')->simplePaginate(10);

        return response()->json(['employees' => $employees], 200);
    }

    public function create(EmployeeRequest $request)
    {
        $input = $request->all();
        $employee = app(Employee::class);

        $employee->create([
            'code' => $input['code'],
            'full_name' => $input['full_name'],
            'user_name' => $input['user_name'],
            'document' => $input['document'],
            'date_birth' => $input['date_birth'],
            'mother_name' => $input['mother_name'],
            'father_name' => $input['father_name'] ?? null,
            'role' => $input['role']
        ]);

        return response()->json(['Funcionário Cadastrado com Sucesso!'], 200);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $input = $request->all();
        $employee = Employee::findOrFail($id);

        $employee->update([
            'code' => $input['code'],
            'full_name' => $input['full_name'],
            'user_name' => $input['user_name'],
            'document' => $input['document'],
            'date_birth' => $input['date_birth'],
            'mother_name' => $input['mother_name'],
            'father_name' => $input['father_name'] ?? null,
            'role' => $input['role']
        ]);

        return response()->json(['Funcionário Atualizado com Sucesso!'], 200);
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete($id);

        return response()->json(['Funcionário Deletado com Sucesso.'], 200);
    }
}
