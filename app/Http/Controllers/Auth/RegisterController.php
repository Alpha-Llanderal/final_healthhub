<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate input
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Begin database transaction
        DB::beginTransaction();

        try {
            // Create user
            $user = $this->create($request->all());

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath = $this->uploadProfilePicture($request->file('profile_picture'), $user->id);
                $user->profile_picture = $profilePicturePath;
                $user->save();
            }

            // Commit transaction
            DB::commit();

            // Log successful registration
            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Redirect with success message
            return redirect()->route('login')
                ->with('success', 'Registration successful! Please log in.');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log error
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'input' => $request->except('password', 'password_confirmation')
            ]);

            // Redirect back with error
            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users,email'
            ],
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed'
            ],
            'birth_date' => ['nullable', 'date'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ], [
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'profile_picture.image' => 'Profile picture must be an image file.',
            'profile_picture.max' => 'Profile picture must not exceed 2MB.'
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'], // Will be hashed by mutator
            'birth_date' => $data['birth_date'] ?? null,
            'is_self_pay' => $data['is_self_pay'] ?? false,
            'address' => $data['address'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
        ]);
    }

    protected function uploadProfilePicture($file, $userId)
    {
        // Generate unique filename
        $filename = $userId . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Store file in public storage
        $path = $file->storeAs('profile_pictures', $filename, 'public');
        
        return $path;
    }
}