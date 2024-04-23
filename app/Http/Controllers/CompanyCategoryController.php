<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'categories' => 'required|array',
        ]);

        $company = Company::findOrFail($request->input('company_id'));

        // Sync the categories
        $categories = Category::whereIn('id', $request->input('categories'))->get();
        $company->categories()->sync($categories);

        return redirect()->route('company.index')->with('success', 'Company categories updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'categories' => 'required|array',
        ]);

        $company = Company::findOrFail($id);

        // Sync the categories
        $categories = Category::whereIn('id', $request->input('categories'))->get();
        $company->categories()->sync($categories);

        return redirect()->route('company.index')->with('success', 'Company categories updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
