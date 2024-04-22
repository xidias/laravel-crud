<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Employee; // Import the Employee model
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$employees = Employee::all();
        $employees = Employee::paginate(25); // Paginate with 25 employees per page
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

    public function random(Request $request)
    {
        // Validation rules for random data
        $validatedData = $request->validate([
            'number_of_records' => 'required|integer|min:1|max:100', // Adjust max limit as needed
        ]);

        $numberOfRecords = $validatedData['number_of_records'];

        // Generate random data and save to database
        for ($i = 0; $i < $numberOfRecords; $i++) {
            $employee = new Employee();
            $employee->full_name = $this->generateRandomName();
            $employee->email = $this->generateRandomEmail();
            $employee->phone = $this->generateRandomPhone();
            $employee->save();
        }
        session()->flash('success', 'Random data generated successfully.');
        return redirect()->route('employee.list');
    }

    // Helper method to generate a random name (you can adjust as needed)
    private function generateRandomName()
    {
        $firstNames = ['John', 'Jane', 'James', 'Emily', 'Michael', 'Sarah', 'David', 'Laura', 'Daniel', 'Emma', 'Oliver', 'Charlotte', 'William', 'Ava', 'Alexander', 'Mia', 'Ethan', 'Sophia', 'Benjamin', 'Isabella', 'Jacob', 'Amelia', 'Lucas', 'Harper', 'Matthew', 'Ella', 'Joseph', 'Grace', 'Henry', 'Chloe', 'Samuel', 'Victoria', 'Elijah', 'Lily', 'Gabriel', 'Natalie', 'Jackson', 'Aria', 'Luke', 'Madison', 'Christopher', 'Zoe', 'Anthony', 'Hannah', 'Isaac', 'Scarlett', 'Andrew', 'Addison', 'Nathan', 'Evelyn'];
        $lastNames = ['Doe', 'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Anderson', 'Wilson', 'Miller', 'Davis', 'Martinez', 'Garcia', 'Rodriguez', 'Hernandez', 'Lopez', 'Gonzalez', 'Perez', 'Thomas', 'Moore', 'Jackson', 'Martin', 'Lee', 'Walker', 'Parker', 'Roberts', 'Clark', 'Lewis', 'Young', 'Hall', 'Allen', 'King', 'Wright', 'Scott', 'Adams', 'Green', 'Evans', 'Baker', 'Nelson', 'Hill', 'Ramirez', 'Campbell', 'Mitchell', 'Robinson', 'Carter', 'Phillips', 'Evans', 'Turner', 'Morris', 'Ward'];
        
        $firstName = $firstNames[array_rand($firstNames)];
        $lastName = $lastNames[array_rand($lastNames)];

        return $firstName . ' ' . $lastName;
    }

    // Helper method to generate a random email
    private function generateRandomEmail()
    {
        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'example.com', 'aol.com', 'outlook.com', 'icloud.com', 'live.com', 'msn.com', 'protonmail.com', 'mail.com', 'zoho.com', 'yandex.com', 'rocketmail.com', 'inbox.com', 'gmx.com', 'fastmail.com', 'tutanota.com', 'earthlink.net', 'cox.net', 'verizon.net', 'att.net', 'sbcglobal.net', 'roadrunner.com', 'optonline.net', 'charter.net', 'juno.com', 'netzero.net', 'prodigy.net', 'compuserve.com', 'aol.co.uk', 'btinternet.com', 'virginmedia.com', 'ntlworld.com', 'talktalk.net'];
        $username = strtolower(Str::random(8)); // Generate a random username (adjust as needed)
        $domain = $domains[array_rand($domains)];

        return $username . '@' . $domain;
    }

    // Helper method to generate a random phone number
    private function generateRandomPhone()
    {
        return mt_rand(1000000000, 9999999999); // Generate a 10-digit random number (adjust as needed)
    }


}
