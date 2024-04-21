<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category', compact('categories'));
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
                'description' => 'nullable|string',
            ]);
    
            // Create a new category using mass assignment
            $category = Category::create($validatedData);
    
            // Flash a success message to the session
            session()->flash('success', 'Category created successfully');
            return redirect()->route('category.list');
        } catch (ValidationException $e) {
            // Validation failed, redirect back with errors
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions, flash error message
            session()->flash('error', 'Error creating category: ' . $e->getMessage());
            return redirect()->route('category.list');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return $category;
    }

    /**
     * Display the specified resource.
     */
    public function modal(string $action,string $id='0') {
        $category = $id != 0 ? Category::findOrFail($id) : NULL;
        return view('category', compact('category','action'));
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
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Return validation errors in JSON format with 422 status code
            //return response()->json(['errors' => $validator->errors()], 422);
            session()->flash('error', $validator->errors());
            return redirect()->route('category.list');
        }

        try {
            $category = Category::findOrFail($id);

            $category->name = $request->input('name');
            $category->description = $request->input('description');

            $category->save();

            // Return a success response
            //return response()->json(['message' => 'Category updated successfully']);
            session()->flash('success', 'Category updated successfully');
            return redirect()->route('category.list');
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            //return response()->json(['message' => 'Error updating category'], 500);
            session()->flash('error', 'Error updating category');
            return redirect()->route('category.list');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the category by ID
            $category = Category::findOrFail($id);
    
            // Delete the category
            $category->delete();
    
            // Flash a success message to the session
            session()->flash('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            // Flash an error message to the session
            session()->flash('error', 'Error deleting category: ' . $e->getMessage());
        }
    
        return redirect()->route('category.list');
    }
}
