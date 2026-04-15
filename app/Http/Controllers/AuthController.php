<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'string|email',
                'name' => 'string|min:3',
                'password' => 'string|min:8|max:32|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            $emailTaken = User::where('email', $validated['email'])->count();
            if ($emailTaken > 0) {
                return redirect()->back()->withErrors('Email sudah digunakan, silahkan ganti');
            }

            User::create($validated);

            $token = Auth::attempt($validated);

            if (! $token) {
                return redirect()->back()->withErrors('Password tidak valid');
            }
            $request->session()->regenerate();

            return redirect()->route('home');
        } catch (\Exception $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Something went wrong');
        }
    }

    public function showRegisterPage()
    {
        return Inertia::render('register');
    }

    public function showLoginPage()
    {
        return Inertia::render('login');
    }
}
