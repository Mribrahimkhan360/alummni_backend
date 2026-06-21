<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'student_id' => 'required|unique:users,student_id',
            'passing_year' => 'required|integer',
            'department'=> 'required|string',
            'gender' => 'required|string',
            'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'passing_year' => $request->passing_year,
            'department' => $request->department,
            'gender' => $request->gender,
            'image' => $imagePath,
            'password' => bcrypt($request->password),
        ]);

        // Generate an authentication token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the user and token in the response
        return response()->json([
            'message' => 'Registration successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password is correct
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        // Generate an authentication token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the user and token in the response
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }
}
