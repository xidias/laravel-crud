<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // Eager load the categories relationship for each company
        $companies = Company::with('categories')->paginate(25); // Paginate with 25 rows per page
        // Fetch all categories separately (assuming they are used elsewhere in the view)
        $categories = Category::all();
        return view('company', compact('companies','categories'));
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
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'description' => 'nullable|string',
                'website' => 'nullable|url',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max size 2MB
                'categories' => 'nullable|array', // Assuming categories are passed as an array of IDs
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('company-logos', 'public');
            } else {
                $logoPath = null;
            }
    
            // Create a new company using mass assignment
            $company = Company::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'description' => $request->input('description'),
                'website' => $request->input('website'),
                'logo' => $logoPath,
            ]);

            // Sync the categories
            if ($request->has('categories')) {
                $categories = Category::whereIn('id', $request->input('categories'))->get();
                $company->categories()->sync($categories);
            }
    
            // Flash a success message to the session
            session()->flash('success', 'Company created successfully');
            return redirect()->route('company.list');
        } catch (ValidationException $e) {
            // Validation failed, redirect back with errors
            session()->flash('success', 'Company updated successfully');
            return redirect()->route('company.list');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating company');
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
        $categories = Category::all();
        return view('company', compact('company','action','categories'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
            'categories' => 'nullable|array', // Assuming categories are passed as an array of IDs
        ]);
    
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return redirect()->route('company.list');
        }
    
        try {
            $company = Company::findOrFail($id);
    
            $company->name = $request->input('name');
            $company->email = $request->input('email');
            $company->description = $request->input('description');
            $company->website = $request->input('website');
    


            if ($request->has('delete_logo') && $request->input('delete_logo') == '1') {
                // Handle logo deletion
                $company->logo = null; // Set the logo field to null in your database
                Storage::delete('public' . $company->logo); // Delete the file from storage (if needed)
                $company->save(); // Save the changes
            }
            else if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($company->logo) {
                    Storage::disk('public')->delete($company->logo);
                }
                $logoPath = $request->file('logo')->store('company-logos', 'public');
                $company->logo = $logoPath;
            }
    
            $company->save();
    
            // Sync the categories
            if ($request->has('categories')) {
                $categories = Category::whereIn('id', $request->input('categories'))->get();
                $company->categories()->sync($categories);
            } else {
                $company->categories()->detach(); // If no categories are selected, detach all existing ones
            }
    
            session()->flash('success', 'Company updated successfully');
            return redirect()->route('company.list');
        } catch (\Exception $e) {
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

            $company->categories()->detach(); // Detach categories before deleting
    
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

    public function random(Request $request)
    {
        $validatedData = $request->validate([
            'number_of_companies' => 'required|integer|min:1|max:100', // Max 100 companies
        ]);
    
        $numberOfCompanies = $validatedData['number_of_companies'];
    
        for ($i = 0; $i < $numberOfCompanies; $i++) {
            $company = new Company();
            $company->name = $this->generateRandomCompanyName();
            $company->email = $this->generateRandomCompanyEmail();
            $company->description = $this->generateRandomCompanyDescription();
            $company->website = $this->generateRandomCompanyWebsite();
            // You may handle logo generation separately if needed
            $company->save();

            // Attach random categories to the company
            $this->attachRandomCategories($company);

        }
        session()->flash('success', 'Random data generated successfully.');
        return redirect()->route('company.list');
    }
    private function generateRandomCompanyName()
    {
        $companyNames = [
            'TechCorp', 'Innovate Solutions', 'Global Enterprises', 'WebWise', 'DataTech', 
            'Software Innovations', 'WebTech Solutions', 'TechGenius', 'Digital Minds', 'ByteCraft', 
            'CodeNinja', 'InfoTech', 'DigitalCraft', 'WebWorks', 'ByteGenius', 'Digital Wave', 
            'InnovaTech', 'CodeWave', 'DataMinds', 'TechWise', 'FutureTech', 'Smart Solutions', 
            'Tech Innovators', 'ByteMaster', 'InnoTech', 'Genius Minds', 'WebGenius', 'Tech Revolution', 
            'DataWorks', 'Digital Creations', 'Tech Wizards', 'TechPulse', 'InnovaSoft', 'DataSavvy', 
            'WebMasters', 'CodeCrafters', 'Tech Visionaries', 'DataWave', 'Digital Fusion', 'Web Fusion', 
            'Code Fusion', 'Tech Fusion', 'Data Fusion', 'InnoFusion', 'WebGurus', 'CodeGurus', 'DataGurus'
        ];        
        return $companyNames[array_rand($companyNames)];
    }

    private function generateRandomCompanyEmail()
    {
        $domains = [
            'gmail.com', 'yahoo.com', 'hotmail.com', 'example.com', 'aol.com', 'outlook.com', 
            'icloud.com', 'live.com', 'msn.com', 'protonmail.com', 'mail.com', 'zoho.com', 
            'yandex.com', 'rocketmail.com', 'inbox.com', 'gmx.com', 'fastmail.com', 'tutanota.com', 
            'earthlink.net', 'cox.net', 'verizon.net', 'att.net', 'sbcglobal.net', 'roadrunner.com', 
            'optonline.net', 'charter.net', 'juno.com', 'netzero.net', 'prodigy.net', 'compuserve.com', 
            'aol.co.uk', 'btinternet.com', 'virginmedia.com', 'ntlworld.com', 'talktalk.net'
        ];
        $username = strtolower(Str::random(8)); // Use Str::random() for random string
        $domain = $domains[array_rand($domains)];

        return $username . '@' . $domain;
    }

    private function generateRandomCompanyDescription()
    {
        // You can customize the descriptions as needed
        $descriptions = [
            'A leading tech company specializing in innovative solutions', 
            'Transforming businesses with cutting-edge technology', 
            'Providing top-notch software solutions for your needs', 
            'Your trusted partner in digital transformation', 
            'Driving innovation and excellence in technology', 
            'Delivering software solutions for a connected world', 
            'Empowering businesses with technology', 
            'Creating digital experiences that matter', 
            'Innovating for a better tomorrow', 
            'Your gateway to technological advancement', 
            'Building the future of technology', 
            'Helping businesses thrive in the digital age', 
            'Enabling growth through technology solutions'
        ];
        return $descriptions[array_rand($descriptions)];
    }

    private function generateRandomCompanyWebsite()
    {
        // Generate a random URL using faker library or manually
        // For example:
        $websites = [
            'https://example.com', 'https://techcorp.com', 'https://innovatesolutions.com', 
            'https://globalenterprises.com', 'https://futuretech.com', 'https://smartsolutions.com', 
            'https://techinnovators.com', 'https://bytemaster.com', 'https://innotech.com', 
            'https://geniusminds.com', 'https://webgenius.com', 'https://techrevolution.com', 
            'https://dataworks.com', 'https://digitalcreations.com', 'https://techwizards.com', 
            'https://techpulse.com', 'https://innovasoft.com', 'https://datasavvy.com', 
            'https://webmasters.com', 'https://codecrafters.com', 'https://techvisionaries.com', 
            'https://datawave.com', 'https://digitalfusion.com', 'https://webfusion.com', 
            'https://codefusion.com', 'https://techfusion.com', 'https://datafusion.com', 
            'https://innofusion.com', 'https://webgurus.com', 'https://codegurus.com', 
            'https://datagurus.com'
        ];
        return $websites[array_rand($websites)];
    }

    private function attachRandomCategories(Company $company)
    {
        $categories = Category::inRandomOrder()->limit(rand(0, 4))->get(); // Randomly select 0 to 4 categories
        $company->categories()->attach($categories);
    }
}
