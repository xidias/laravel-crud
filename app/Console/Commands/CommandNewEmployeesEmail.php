<?php

namespace App\Console\Commands;

use App\Models\User; // Assuming User model for admins
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewEmployeesEmail;
use App\Models\Employee;

class CommandNewEmployeesEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-employees-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all admins (you may need to adjust this query based on your user roles)
        $admins = User::where('role', 'admin')->get();
       $employees = Employee::where('created_at', '>=', now()->subHours(24))->get();

       //$employees = Employee::take(5)->get(); // Retrieve up to 5 employees

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new SendNewEmployeesEmail($employees));
        }

        $this->info('Test email sent to all admins.');
    }

}
