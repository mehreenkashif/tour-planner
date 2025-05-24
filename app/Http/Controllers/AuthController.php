<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerForm()
    {
        if (Auth::check()) {
            return redirect()->route('tours.index');
        }

        return view('auth.register');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,tour_planner',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);


        if (Auth::check()) {
            // Admin is creating a user
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } else {
            // Normal user self-registration
            Auth::login($user);
            return redirect()->route('tours.index')->with('success', 'Welcome! Your account has been created.');
        }





    }

    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('tours.index');
        }

        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('tours.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}




















// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// class AuthController extends Controller
// {

//     public function registerForm()
//     {

//         if (Auth::check()) {
//             return redirect()->route('tours.index');
//         }

//         return view('auth.register');
//     }

//     public function registerUser(Request $request)
//     {

//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required|string|min:6|confirmed',
//             'role' => 'required|in:user,tour_planner',
//         ]);


//         $user=User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'role' => $request->role,
//         ]);

//         if (!auth()->check()) {
//             Auth::login($user);
//             return redirect()->route('home');
//         }


//         return redirect()->route('users.index')->with('success', 'User created!');

//         $route = $user->role === 'admin' ? 'dashboard' : 'tours.index';
//         return redirect()->route($route)->with('success', 'Welcome!');
//     }

//     public function loginForm()
//     {
//         if (Auth::check()) {
//             return redirect()->route('tours.index');
//         }

//         return view('auth.login');
//     }

//     public function loginUser(Request $request)
//     {
//         $credentials = $request->only('email', 'password');

//         if (Auth::attempt($credentials)) {
//             $request->session()->regenerate();
//             return redirect()->intended(route('tours.index'));
//         }

//         return back()->withErrors([
//             'email' => 'The provided credentials do not match our records.',
//         ]);
//     }

//     public function logout(Request $request)
//     {
//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         return redirect()->route('login');
//     }
// }
