<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Company;
use App\Models\InviteLink;
use Illuminate\Support\Str;
use App\Mail\InviteMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;




class CompanyController extends Controller
{
    public function createCompanyPage()
    {
        Gate::allows('isSuperAdmin');
        return view('company.create');
    }

    public function storeNewCompany(Request $request)
    {
        Gate::allows('isSuperAdmin');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:invite_links,email',
        ]);
        $role_id = Role::Where('name', 'admin')->first()->id;
        $dataCompany = Company::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $send_invite = InviteLink::create([
            'name' => $request->name ?? '',
            'email' => $request->email,
            'password_token' => Str::random(32),
            'role_id' => $role_id,
            'company_id' => $dataCompany->id,
        ]); 

        $to = $send_invite->email;
        $subject = "Invitation to Join as Admin For " . $dataCompany->name;
        $message = url('/invite/' . $send_invite->password_token);
        // Mail Code 
        dispatch(function() use ($to, $subject, $message){
            Mail::to($to)->send(new InviteMail($subject,$message));
        })->delay(now()->addSeconds(5));

        return redirect()->route('dashboard')->with('success', 'Company created successfully!');
    }

    public function companyList()
    {
        Gate::allows('isSuperAdmin');
        $Companies = Company::paginate(10);
        return view('company.company_list', compact('Companies'));
    }
}
