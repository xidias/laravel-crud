<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
}
