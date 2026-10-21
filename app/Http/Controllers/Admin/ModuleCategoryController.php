<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModuleCategory;
use App\Models\User;
use App\Models\UserModuleAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleCategoryController extends Controller
{
    /**
     * Display a listing of categories and private access management.
     */
    public function index()
    {
        $categories = ModuleCategory::withCount('modules')
            ->ordered()
            ->paginate(15);

        // Fetch all user module accesses for private module tracking
        $accessList = UserModuleAccess::with(['user', 'category', 'grantedBy'])
            ->latest()
            ->paginate(15, ['*'], 'access_page');

        // All users for manual access grant dropdown
        $users = User::orderBy('name', 'asc')->get(['id', 'name', 'email', 'username']);

        return view('admin.modules.categories', compact('categories', 'accessList', 'users'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_public' => 'nullable|boolean',
            'referral_code' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'badge' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (ModuleCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $isPublic = $request->has('is_public') ? $request->boolean('is_public') : true;

        $category = ModuleCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_public' => $isPublic,
            'referral_code' => $request->referral_code ? strtoupper(trim($request->referral_code)) : null,
            'icon' => $request->icon ?: 'fas fa-book',
            'color' => $request->color ?: '#38bdf8',
            'badge' => $request->badge,
            'order' => $request->order ?? (ModuleCategory::max('order') + 1),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori modul berhasil ditambahkan!',
                'category' => $category,
            ]);
        }

        return redirect()->route('admin.module-categories.index')
            ->with('success', 'Modul "' . $category->name . '" berhasil ditambahkan!');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $category = ModuleCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'description' => 'nullable|string',
            'is_public' => 'nullable|boolean',
            'referral_code' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'badge' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $isPublic = $request->has('is_public') ? $request->boolean('is_public') : $category->is_public;

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_public' => $isPublic,
            'referral_code' => $request->referral_code ? strtoupper(trim($request->referral_code)) : null,
            'icon' => $request->icon ?: 'fas fa-book',
            'color' => $request->color ?: '#38bdf8',
            'badge' => $request->badge,
            'order' => $request->order ?? $category->order,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : false,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Modul berhasil diperbarui!',
                'category' => $category,
            ]);
        }

        return redirect()->route('admin.module-categories.index')
            ->with('success', 'Modul "' . $category->name . '" berhasil diperbarui!');
    }

    /**
     * Manually grant a user access to a private module category.
     */
    public function grantAccess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:module_categories,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $category = ModuleCategory::findOrFail($request->category_id);

        UserModuleAccess::updateOrCreate(
            [
                'user_id' => $user->id,
                'category_id' => $category->id,
            ],
            [
                'access_method' => 'admin_manual',
                'granted_by' => auth()->id(),
            ]
        );

        return redirect()->route('admin.module-categories.index')
            ->with('success', 'Akses ke modul "' . $category->name . '" berhasil diberikan kepada ' . $user->name . '!');
    }

    /**
     * Revoke manual or referral access.
     */
    public function revokeAccess($id)
    {
        $access = UserModuleAccess::findOrFail($id);
        $userName = $access->user ? $access->user->name : 'User';
        $access->delete();

        return redirect()->route('admin.module-categories.index')
            ->with('success', 'Akses modul untuk ' . $userName . ' berhasil dicabut.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = ModuleCategory::findOrFail($id);
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.module-categories.index')
            ->with('success', 'Modul "' . $name . '" dan seluruh bab di dalamnya berhasil dihapus!');
    }
}
