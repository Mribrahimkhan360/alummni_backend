<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ResetPassword;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'student_id' => 'required|unique:users,student_id',
            'passing_year' => 'required|integer',
            'department' => 'required|string',
            'gender' => 'required|string',
            'image' => 'nullable',
            'password' => 'required|string|min:8',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'student_id' => $validated['student_id'],
            'passing_year' => $validated['passing_year'],
            'department' => $validated['department'],
            'gender' => $validated['gender'],
            'image' => $imagePath,
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('Alumni');

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->load('roles'),
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        // Payment::where('user_id', $user->id)
        // ->where('status', 'approved')
        // ->whereDate('payment_date', '<=', Carbon::now()->subYear())
        // ->update([
        //     'status' => 'expired'
        // ]);


        Payment::where('user_id', $user->id)
            ->where('status','approved')
            ->whereDate('payment_date', '<=', Carbon::now()->subYear())
            ->update([
                'status' => 'expired'
            ]);

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->load('roles'),
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $token = \Str::random(60);

        \DB::table('reset_passwords')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $frontendUrl = 'http://localhost:5173';
        $resetLink = $frontendUrl . '/reset-password?token=' . $token . '&email=' . urlencode($user->email);

        Mail::to($user->email)->send(new ResetPasswordMail($resetLink));

        return response()->json([
            'message' => 'Password reset link sent to your email.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetPassword = \DB::table('reset_passwords')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetPassword) {
            return response()->json([
                'message' => 'Invalid token or email.',
            ], 400);
        }

        $createdAt = Carbon::parse($resetPassword->created_at);
        if (now()->diffInMinutes($createdAt) > 60) {
            \DB::table('reset_passwords')->where('email', $request->email)->delete();
            return response()->json([
                'message' => 'Token has expired. Please request a new reset link.',
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        \DB::table('reset_passwords')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Password has been reset successfully.',
        ]);
    }
}
