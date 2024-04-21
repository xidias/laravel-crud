<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Employee; // Import the Employee model

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employee', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|max:255',
            ]);
    
            // Create a new employee using mass assignment
            $employee = Employee::create($validatedData);
    
            // Flash a success message to the session
            session()->flash('success', 'Employee created successfully');
            return redirect()->route('employee.list');
        } catch (ValidationException $e) {
            // Validation failed, redirect back with errors
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions, flash error message
            session()->flash('error', 'Error creating employee: ' . $e->getMessage());
            return redirect()->route('employee.list');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);
        return $employee;
    }

    /**
     * Display the specified resource.
     */
    public function modal(string $action,string $id='0') {
        $employee = $id != 0 ? Employee::findOrFail($id) : NULL;
        return view('employee', compact('employee','action'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Use Validator facade to perform validation
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Return validation errors in JSON format with 422 status code
            //return response()->json(['errors' => $validator->errors()], 422);
            session()->flash('error', $validator->errors());
            return redirect()->route('employee.list');
        }

        try {
            $employee = Employee::findOrFail($id);

            $employee->full_name = $request->input('full_name');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');

            $employee->save();

            // Return a success response
            //return response()->json(['message' => 'Employee updated successfully']);
            session()->flash('success', 'Employee updated successfully');
            return redirect()->route('employee.list');
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            //return response()->json(['message' => 'Error updating employee'], 500);
            session()->flash('error', 'Error updating employee');
            return redirect()->route('employee.list');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the employee by ID
            $employee = Employee::findOrFail($id);
    
            // Delete the employee
            $employee->delete();
    
            // Flash a success message to the session
            session()->flash('success', 'Employee deleted successfully');
        } catch (\Exception $e) {
            // Flash an error message to the session
            session()->flash('error', 'Error deleting employee: ' . $e->getMessage());
        }
        return redirect()->route('employee.list');
    }
}
