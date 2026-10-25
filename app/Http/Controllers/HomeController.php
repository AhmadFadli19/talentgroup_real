<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $courses = \App\Models\Course::where('is_active', true)->withCount('questions')->latest()->take(6)->get();
        return view("Home.index", compact('courses'));
    }

    public function streamFile(?string $path = null)
    {
        if (empty($path)) {
            return redirect('/');
        }

        // Clean requested path to prevent Directory Traversal
        $cleanPath = trim(str_replace(['../', '..\\'], '', $path), '/');
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }
        if (str_starts_with($cleanPath, 'public/')) {
            $cleanPath = substr($cleanPath, 7);
        }

        // Disallow direct access to sensitive internal storage folders
        if (
            str_starts_with($cleanPath, 'framework') ||
            str_starts_with($cleanPath, 'logs') ||
            str_starts_with($cleanPath, 'private') ||
            str_contains($cleanPath, '.env')
        ) {
            abort(403, 'Akses ke berkas internal ini dibatasi.');
        }

        // 1. Direct filesystem check in storage/app/public
        $fullPath = storage_path('app/public/' . $cleanPath);
        if (file_exists($fullPath) && is_file($fullPath)) {
            return response()->file($fullPath, [
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        }

        // 2. Check public disk via Storage facade
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
            $absPath = \Illuminate\Support\Facades\Storage::disk('public')->path($cleanPath);
            if (file_exists($absPath) && is_file($absPath)) {
                return response()->file($absPath, [
                    'Cache-Control' => 'public, max-age=31536000',
                ]);
            }
        }

        // 3. Fallback direct filesystem in storage/app (for non-sensitive items)
        $fullLocalPath = storage_path('app/' . $cleanPath);
        if (file_exists($fullLocalPath) && is_file($fullLocalPath)) {
            return response()->file($fullLocalPath, [
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        }

        abort(404, 'File storage tidak ditemukan: ' . $cleanPath);
    }
}
