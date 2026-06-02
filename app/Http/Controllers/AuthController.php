<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Fungsi untuk daftar pengguna baru
    public function register(Request $request)
    {
        $dataValidasi = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $pengguna = User::create([
            'name' => $dataValidasi['name'],
            'email' => $dataValidasi['email'],
            'password' => Hash::make($dataValidasi['password']),
        ]);

        $tokenMasuk = $pengguna->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $pengguna,
                'token' => $tokenMasuk
            ],
            'message' => 'Registrasi berhasil'
        ], 201);
    }

    // Fungsi untuk masuk aplikasi
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $pengguna = User::where('email', $request->email)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan salah.']
            ]);
        }

        $pengguna->tokens()->delete();
        $tokenMasuk = $pengguna->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $pengguna,
                'token' => $tokenMasuk
            ],
            'message' => 'Login berhasil'
        ]);
    }
}