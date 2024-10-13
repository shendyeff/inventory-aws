<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'role' => 'required|string|in:Customer,Admin', // Validasi role
        ]);

        \Log::info('Data before saving:', $validatedData);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone_number' => $validatedData['phone_number'],
            'address' => $validatedData['address'],
            'role' => $validatedData['role'], // Simpan role
        ]);

        \Log::info('User created:', $user->toArray());

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');
    }
}
