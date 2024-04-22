<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
//use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');; // Redirect to home
        }
        $categories = Category::paginate(25); // Paginate with 25 rows per page
        $user = auth()->user()->role;
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

    public function random(Request $request)
    {
        $validatedData = $request->validate([
            'number_of_categories' => 'required|integer|min:1|max:10', // Max 10 categories
        ]);

        $numberOfCategories = $validatedData['number_of_categories'];

        for ($i = 0; $i < $numberOfCategories; $i++) {
            $category = new Category();
            $category->name = $this->generateRandomCategoryName();
            $category->description = $this->generateRandomCategoryDescription();
            $category->save();
        }
        session()->flash('success', 'Random data generated successfully.');
        return redirect()->route('category.list');
    }

    private function generateRandomCategoryName()
    {
        $categoryNames = [
            'Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Automotive', 
            'Hospitality', 'Real Estate', 'Entertainment', 'Fashion', 'Sports', 'Travel', 
            'Food & Beverage', 'Energy', 'Manufacturing', 'Telecommunications', 'Construction', 
            'Marketing', 'Consulting', 'Insurance', 'Agriculture', 'Pharmaceutical', 'Media', 
            'Legal', 'Engineering', 'Government', 'Non-Profit', 'Environmental', 'Fitness', 
            'Beauty', 'Music', 'Art', 'Design', 'Transportation', 'Logistics', 'Science', 
            'Research', 'Security', 'Software', 'Hardware', 'Internet', 'E-commerce', 'Health & Wellness'
        ];
        return $categoryNames[array_rand($categoryNames)];
    }

    private function generateRandomCategoryDescription()
    {
        // You can customize the descriptions as needed
        $descriptions = [
            'A leading category in the industry', 'Innovative solutions for this category', 
            'Transforming businesses in this sector', 'Providing top-notch services', 
            'Your trusted partner in this domain', 'Driving excellence in this field', 
            'Pioneering new advancements in this area', 'Empowering businesses in this category', 
            'Shaping the future of this industry', 'Revolutionizing the way we approach this sector', 
            'Bringing cutting-edge technology to this field', 'Creating impactful solutions', 
            'Building a strong presence in this domain', 'Delivering unmatched expertise', 
            'Catering to diverse needs in this category', 'Fostering innovation and growth', 
            'Elevating standards in this sector', 'Embracing digital transformation', 
            'Connecting businesses globally', 'Leading with creativity and vision', 
            'Navigating challenges with expertise', 'Inspiring change and progress', 
            'Harnessing the power of technology', 'Driving success in this field', 
            'Cultivating partnerships and collaborations', 'Adapting to changing landscapes', 
            'Championing innovation and sustainability', 'Empowering people and businesses', 
            'Exploring new frontiers in this area', 'Creating value and impact', 
            'Advancing the industry through excellence', 'Shaping a brighter future', 
            'Creating memorable experiences', 'Enriching lives through our services', 
            'Building a legacy of excellence', 'Empowering individuals and communities', 
            'Leading with integrity and passion', 'Inspiring confidence and trust', 
            'Making a positive difference', 'Crafting solutions that matter', 
            'Driving positive change and growth', 'Empowering you to succeed'
        ];
        return $descriptions[array_rand($descriptions)];
    }

}
