<?php

namespace App\Http\Controllers;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     public function loginForm()
    {
        return view('auth.login');
    }
     public function login(Request $request)
    {
        $request->validate([
            'username'    => 'required',
            'password' => 'required|min:6'
        ]); 
        $user = Users::where('name', $request->username)->first(); 
        if ($user && Hash::check($request->password, $user->password)) { 
            $request->session()->put('user', [
                'id'   => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'email'=> $user->email
            ]); 
            if ($user->role === 'candidate') {
            return redirect('/view-jobs')->with('success', 'Logged in successfully!');
        } elseif ($user->role === 'recruiter') {
            return redirect('/recruiter-dashboard')->with('success', 'Logged in successfully!');
        }elseif ($user->role === 'techreviewer') {
            return redirect('/tech-reviewer')->with('success', 'Logged in successfully!');
        }elseif ($user->role === 'hrreviewer') {
            return redirect('/hr-reviewer')->with('success', 'Logged in successfully!');
        } else { 
            return redirect('/login')->with('error', 'Invalid role.');
        }
        } else {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    } 
    public function logout(Request $request)
    {
        $request->session()->forget('user');  
        $request->session()->flush(); 
        return redirect('/login')->with('success', 'Logged out successfully!');
    }
    public function register(Request $request)
{
    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:6',
        'role'     => 'required|in:candidate,recruiter,hrreviewer,techreviewer'
    ]);

    Users::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
    ]);

    return redirect('/login')->with('success', 'Registration successful! Please login.');
}

}
