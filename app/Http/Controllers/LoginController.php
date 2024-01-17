<?php

namespace App\Http\Controllers;

use App\Models\UserT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = UserT::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password_hash)) {
            $token = Str::random(60);

            $user->update(['token' => $token]);

            return response()->json(['message' => 'Login successful', 'token' => $token, 'response' => "logged"], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials']);
        }
    }
}
