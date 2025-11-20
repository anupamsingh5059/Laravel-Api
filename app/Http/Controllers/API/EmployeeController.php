<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{


        public function index() {
    $employees = Employee::all();
    return view('employees.index', compact('employees'));
}

        //     public function index()
        // {
        // return response()->json(Employee::latest()->paginate(10));
        // }


public function store(Request $request)
{
$validator = Validator::make($request->all(), [
'name' => 'required|string|max:255',
'email' => 'required|email|unique:employees,email',
'phone' => 'nullable|string',
'position' => 'nullable|string',
]);


if ($validator->fails()) {
return response()->json(['errors' => $validator->errors()], 422);
}


$employee = Employee::create($request->only(['name','email','phone','position']));


return response()->json($employee, 201);
}


public function show($id)
{
$employee = Employee::findOrFail($id);
return response()->json($employee);
}


public function update(Request $request, $id)
{
$employee = Employee::findOrFail($id);


$validator = Validator::make($request->all(), [
'name' => 'sometimes|required|string|max:255',
'email' => 'sometimes|required|email|unique:employees,email,'.$employee->id,
'phone' => 'nullable|string',
'position' => 'nullable|string',
]);


if ($validator->fails()) {
return response()->json(['errors' => $validator->errors()], 422);
}


$employee->update($request->only(['name','email','phone','position']));


return response()->json($employee);
}


public function destroy($id)
{
$employee = Employee::findOrFail($id);
$employee->delete();
return response()->json(['message' => 'Employee deleted']);
}
    
}
