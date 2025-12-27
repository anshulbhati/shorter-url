<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\InviteLink;
use Illuminate\Support\Str;
use App\Mail\InviteMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;



class InviteController extends Controller
{
   
    public function inviteMemberPage(){
        Gate::allows('admin-or-member');
        $role = auth()->user()->roles()->pluck('name')->toArray();
        $roleIn = $role === ['admin'] ? ['super_admin'] : ['super_admin', 'admin'];
        $roles = Role::select('id', 'name')->whereNotIn('name', $roleIn)->get();
        return view('invite.invite-member', compact('roles'));
    }

    public function inviteMemberSend(Request $request){
        Gate::allows('admin-or-member');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:invite_links,email',
            'role_id' => 'required|exists:roles,id',
        ]);
        $send_invite = InviteLink::create([
            'name' => $request->name,
            'email' => $request->email,
            'password_token' => Str::random(32),
            'role_id' => $request->role_id,
            'company_id' => auth()->user()->company_id,
        ]);

        $to = $send_invite->email;
        $subject = "Invitation to Join " . auth()->user()->company->name .'As '.$send_invite->role->name;
        $message = url('/invite/' . $send_invite->password_token);

        dispatch(function() use ($to, $subject, $message){
            Mail::to($to)->send(new InviteMail($subject,$message));
        })->delay(now()->addSeconds(5));
        
        return redirect()->route('invite.member.page')->with('success', 'Invitation sent successfully!');

    }
    public function memberList(){
        Gate::allows('admin-or-member');
        $role = auth()->user()->roles()->pluck('name')->toArray();
        $members = in_array('admin', $role)
            ? \App\Models\User::where('company_id', auth()->user()->company_id)->paginate(10)
            : \App\Models\User::where('id', auth()->id())->paginate(10);
        return view('invite.member_list', compact('members'));
    }
}
