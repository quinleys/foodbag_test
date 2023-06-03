<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HeartbeatController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'message' => 'The API is alive and well',
        ]);
    }
}
