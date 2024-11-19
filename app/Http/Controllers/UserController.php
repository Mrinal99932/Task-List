<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'You are now logged in.');
        }

        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('dashboard')->with('success', 'You have been logged out.');
    }
    public function signup()
    {
        return view('signup');
    }
    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:userrequests',
            'phone' => 'required|string|max:15|unique:userrequests',
            'password' => 'required|string|min:6',
        ]);

        UserRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('dashboard')->with('status', 'Signup request sent successfully!');
    }
    public function userrequest()
    {
        $userRequests = UserRequest::get();
        return view('user-request',compact('userRequests'));
    }

    public function acceptRequest($id)
    {
        $userRequest = UserRequest::findOrFail($id);

        User::create([
            'name' => $userRequest->name,
            'email' => $userRequest->email,
            'phone' => $userRequest->phone,
            'password' => bcrypt($userRequest->password), 
        ]);

        
        $userRequest->delete();

        
        return redirect()->route('user-request')->with('status', 'User request accepted successfully!');
    }
}
