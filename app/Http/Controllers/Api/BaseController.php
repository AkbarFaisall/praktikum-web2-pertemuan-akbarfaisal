<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected function success($data = null, $pesan = null, $kode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $pesan,
            'data' => $data,
        ], $kode);
    }

    protected function error($pesan = null, $kode = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $pesan,
        ], $kode);
    }
}