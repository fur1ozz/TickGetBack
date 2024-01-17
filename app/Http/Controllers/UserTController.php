<?php
namespace App\Http\Controllers;

use App\Models\UserT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserTController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:usersT',
                'password' => 'required|string',
            ]);

            $user = UserT::create([
                'username' => 'anonymous',
                'email' => $request->input('email'),
                'password_hash' => Hash::make($request->input('password')),
                'full_name' => 'Anonymous User',
                'access' => 'user',
                'token' => '',
            ]);

            return response()->json(['message' => 'User registered successfully', 'user' => $user, 'response' => "good"], 201);
        } catch (ValidationException $e) {
            if ($e->errors()['email'][0] === 'The email has already been taken.') {
                return response()->json(['message' => 'Email is already in use']);
            }

            throw $e;
        }
    }
}
