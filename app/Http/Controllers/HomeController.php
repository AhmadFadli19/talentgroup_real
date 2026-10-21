<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $courses = \App\Models\Course::where('is_active', true)->withCount('questions')->latest()->take(6)->get();
        return view("Home.index", compact('courses'));
    }

    public function streamFile($path)
    {
        // 1. Check public disk
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            $file = \Illuminate\Support\Facades\Storage::disk('public')->get($path);
            $type = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($path) ?: 'application/octet-stream';
            return response($file, 200)->header('Content-Type', $type);
        }

        // 2. Check local disk
        if (\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
            $file = \Illuminate\Support\Facades\Storage::disk('local')->get($path);
            $type = \Illuminate\Support\Facades\Storage::disk('local')->mimeType($path) ?: 'application/octet-stream';
            return response($file, 200)->header('Content-Type', $type);
        }

        // 3. Fallback direct filesystem in storage/app/public
        $fullPath = storage_path('app/public/' . $path);
        if (file_exists($fullPath) && is_file($fullPath)) {
            return response()->file($fullPath);
        }

        // 4. Fallback direct filesystem in storage/app
        $fullLocalPath = storage_path('app/' . $path);
        if (file_exists($fullLocalPath) && is_file($fullLocalPath)) {
            return response()->file($fullLocalPath);
        }

        abort(404, 'File tidak ditemukan: ' . $path);
    }
}
