<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Fungsi untuk mengecek hak akses pengguna
    public function handle(Request $request, Closure $next, string $aturanAkses): Response
    {
        $pengguna = $request->user();
        
        if (!$pengguna || $pengguna->role !== $aturanAkses) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Akses ditolak. Anda bukan ' . $aturanAkses
            ], 403);
        }

        return $next($request);
    }
}