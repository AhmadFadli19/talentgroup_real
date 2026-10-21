<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ModuleCategory;
use App\Models\ReferralCode;
use Illuminate\Http\Request;

class ReferralCodeController extends Controller
{
    /**
     * Display a listing of referral codes.
     */
    public function index(Request $request)
    {
        $query = ReferralCode::with(['creator', 'usages.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('discount_type', $request->type);
        }

        if ($request->filled('target')) {
            $query->where('target_type', $request->target);
        }

        $referralCodes = $query->latest()->paginate(15)->withQueryString();
        $courses = Course::where('is_active', true)->get();
        $moduleCategories = ModuleCategory::ordered()->get();

        return view('admin.referral_codes.index', compact('referralCodes', 'courses', 'moduleCategories'));
    }

    /**
     * Show the form for creating a new referral code.
     */
    public function create()
    {
        $courses = Course::where('is_active', true)->get();
        $moduleCategories = ModuleCategory::ordered()->get();

        return view('admin.referral_codes.create', compact('courses', 'moduleCategories'));
    }

    /**
     * Store a newly created referral code.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:referral_codes,code',
            'description' => 'nullable|string|max:255',
            'discount_type' => 'required|in:free,percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'target_type' => 'required|in:all,course,module',
            'target_id' => 'nullable|integer',
            'max_uses' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $code = strtoupper(trim($request->code));
        $discountValue = $request->discount_type === 'free' ? 100 : ($request->discount_value ?? 0);

        ReferralCode::create([
            'code' => $code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $discountValue,
            'target_type' => $request->target_type,
            'target_id' => $request->target_type === 'all' ? null : $request->target_id,
            'max_uses' => $request->max_uses,
            'is_active' => $request->boolean('is_active', true),
            'expires_at' => $request->expires_at,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.referral-codes.index')
            ->with('success', 'Kode referral "' . $code . '" berhasil dibuat!');
    }

    /**
     * Show the form for editing the referral code.
     */
    public function edit($id)
    {
        $referralCode = ReferralCode::findOrFail($id);
        $courses = Course::where('is_active', true)->get();
        $moduleCategories = ModuleCategory::ordered()->get();

        return view('admin.referral_codes.edit', compact('referralCode', 'courses', 'moduleCategories'));
    }

    /**
     * Update the specified referral code.
     */
    public function update(Request $request, $id)
    {
        $referralCode = ReferralCode::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:referral_codes,code,' . $id,
            'description' => 'nullable|string|max:255',
            'discount_type' => 'required|in:free,percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'target_type' => 'required|in:all,course,module',
            'target_id' => 'nullable|integer',
            'max_uses' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $code = strtoupper(trim($request->code));
        $discountValue = $request->discount_type === 'free' ? 100 : ($request->discount_value ?? 0);

        $referralCode->update([
            'code' => $code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $discountValue,
            'target_type' => $request->target_type,
            'target_id' => $request->target_type === 'all' ? null : $request->target_id,
            'max_uses' => $request->max_uses,
            'is_active' => $request->boolean('is_active', true),
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.referral-codes.index')
            ->with('success', 'Kode referral "' . $code . '" berhasil diperbarui!');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive($id)
    {
        $referralCode = ReferralCode::findOrFail($id);
        $referralCode->is_active = !$referralCode->is_active;
        $referralCode->save();

        return response()->json([
            'success' => true,
            'is_active' => $referralCode->is_active,
            'message' => 'Status kode referral berhasil diubah.',
        ]);
    }

    /**
     * Remove the specified referral code.
     */
    public function destroy($id)
    {
        $referralCode = ReferralCode::findOrFail($id);
        $code = $referralCode->code;
        $referralCode->delete();

        return redirect()->route('admin.referral-codes.index')
            ->with('success', 'Kode referral "' . $code . '" berhasil dihapus!');
    }
}
