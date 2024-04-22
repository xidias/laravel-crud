<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $companies = Company::paginate(25);
        return view('company', compact('companies'));
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'description' => 'nullable|string',
                'website' => 'nullable|url',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max size 2MB
            ]);

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validatedData['logo'] = $logoPath;
            }
    
            // Create a new company using mass assignment
            $company = Company::create($validatedData);
    
            // Flash a success message to the session
            session()->flash('success', 'Company created successfully');
            return redirect()->route('company.list');
        } catch (ValidationException $e) {
            // Validation failed, redirect back with errors
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions, flash error message
            session()->flash('error', 'Error creating company: ' . $e->getMessage());
            return redirect()->route('company.list');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return $company;
    }

    /**
     * Display the specified resource.
     */
    public function modal(string $action,string $id='0') {
        $company = $id != 0 ? Company::findOrFail($id) : NULL;
        return view('company', compact('company','action'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Return validation errors in JSON format with 422 status code
            //return response()->json(['errors' => $validator->errors()], 422);
            session()->flash('error', $validator->errors());
            return redirect()->route('company.list');
        }

        try {
            $company = Company::findOrFail($id);

            $company->name = $request->input('name');
            $company->email = $request->input('email');
            $company->description = $request->input('description');
            $company->website = $request->input('website');
            $company->logo = $request->input('logo');

            $company->save();

            // Return a success response
            //return response()->json(['message' => 'Company updated successfully']);
            session()->flash('success', 'Company updated successfully');
            return redirect()->route('company.list');
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            //return response()->json(['message' => 'Error updating company'], 500);
            session()->flash('error', 'Error updating company');
            return redirect()->route('company.list');
        }

    }    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the company by ID
            $company = Company::findOrFail($id);
    
            // Delete the company
            $company->delete();
    
            // Flash a success message to the session
            session()->flash('success', 'Company deleted successfully');
        } catch (\Exception $e) {
            // Flash an error message to the session
            session()->flash('error', 'Error deleting company: ' . $e->getMessage());
        }
    
        return redirect()->route('company.list');
    }
}
