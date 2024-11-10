<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    // Constructor to set middleware
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Method to show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Validator method
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // User creation method
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // Registration handler
    public function register(Request $request)
    {
        // Validate the input
        $this->validator($request->all())->validate();

        // Create the user and trigger Registered event
        $user = $this->create($request->all());
        event(new Registered($user));

        // Redirect to login with success message
        return redirect()->route('login')->with('status', 'Registration successful! You can now log in.');
    }
}