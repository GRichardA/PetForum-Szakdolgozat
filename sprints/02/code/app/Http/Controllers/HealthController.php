<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HealthController extends Controller
{
    public function index()
    {
        $dbStatus = 'ok';
        try {
            DB::select('SELECT 1');
        } catch (\Throwable $e) {
            $dbStatus = 'error';
        }

        $storageWritable = Storage::disk('public')->exists('.') ? 'writable' : 'not_writable';

        return response()->json([
            'status' => 'ok',
            'database' => $dbStatus,
            'storage' => $storageWritable,
        ]);
    }
}
