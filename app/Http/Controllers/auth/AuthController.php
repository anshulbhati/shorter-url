<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\InviteLink;
use App\Models\User;

class AuthController extends Controller
{
    public function loginPage(Request $request)
    {
        return view('auth.login');
    }

    public function loginStore(Request $request)
    {
        $login_data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($login_data) {
            if (Auth::attempt($login_data)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard')->with('success', 'Logged in successfully!');
            }else{
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])->onlyInput('email');
            }
        }
    }

    public function invitePage($token)
    {
        $validatetoken = InviteLink::where('password_token', $token)->exists();
        if(!$validatetoken){
            return redirect()->route('login')->with('error','Invalid Invite Link');
        }
        return view('auth.passwordSet', compact('token'));
    }

    public function registration(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'token' => 'required|string|exists:invite_links,password_token',
        ]);

        $invite = InviteLink::where('password_token', $request->token)->first();

        $user = User::create([
            'email' => $invite->email,
            'password' => Hash::make($request->password),
            'company_id' => $invite->company_id,
        ]);
        $user->roles()->attach($invite->role_id);
        $invite->delete();
        Auth::login($user);
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logged out successfully!');
    }
}
