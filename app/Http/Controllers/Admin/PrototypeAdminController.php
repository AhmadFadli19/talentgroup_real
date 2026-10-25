<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiSetting;
use App\Models\Prototype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrototypeAdminController extends Controller
{
    /**
     * Display list of all prototypes with search and filters.
     */
    public function index(Request $request)
    {
        $query = Prototype::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'suspended') {
                $query->where('is_active', false);
            }
        }

        $prototypes = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Prototype::count(),
            'active' => Prototype::where('is_active', true)->where('is_hosted', true)->count(),
            'suspended' => Prototype::where('is_active', false)->count(),
            'avg_score' => round(Prototype::avg('ai_score') ?? 0),
        ];

        return view('admin.prototypes.index', compact('prototypes', 'stats'));
    }

    /**
     * Show AI & Hosting Settings page.
     */
    public function settings()
    {
        $settings = AiSetting::getSettings();
        return view('admin.prototypes.settings', compact('settings'));
    }

    /**
     * Update AI & Hosting Settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'active_provider' => 'required|in:openai,gemini,deepseek,qwen',
            'openai_api_key' => 'nullable|string',
            'openai_model' => 'nullable|string',
            'gemini_api_key' => 'nullable|string',
            'gemini_model' => 'required|string',
            'deepseek_api_key' => 'nullable|string',
            'deepseek_model' => 'required|string',
            'qwen_api_key' => 'nullable|string',
            'qwen_model' => 'required|string',
            'min_passing_score' => 'required|integer|min:0|max:100',
            'custom_rules_prompt' => 'nullable|string',
        ]);

        $settings = AiSetting::getSettings();

        $settings->update([
            'active_provider' => $request->active_provider,
            'openai_api_key' => $request->openai_api_key,
            'openai_model' => $request->openai_model ?: 'gpt-4o-mini',
            'gemini_api_key' => $request->gemini_api_key,
            'gemini_model' => $request->gemini_model,
            'deepseek_api_key' => $request->deepseek_api_key,
            'deepseek_model' => $request->deepseek_model,
            'qwen_api_key' => $request->qwen_api_key,
            'qwen_model' => $request->qwen_model,
            'min_passing_score' => $request->min_passing_score,
            'check_seo' => $request->boolean('check_seo'),
            'check_performance' => $request->boolean('check_performance'),
            'check_code_errors' => $request->boolean('check_code_errors'),
            'check_best_practices' => $request->boolean('check_best_practices'),
            'check_security' => $request->boolean('check_security'),
            'custom_rules_prompt' => $request->custom_rules_prompt,
        ]);

        return redirect()->route('admin.prototype-settings.index')
            ->with('success', 'Konfigurasi AI Provider & Kriteria Analisa Prototype berhasil diperbarui!');
    }

    /**
     * Toggle active / suspend status of a prototype.
     */
    public function toggleActive($id)
    {
        $prototype = Prototype::findOrFail($id);
        $prototype->is_active = !$prototype->is_active;
        $prototype->save();

        $statusText = $prototype->is_active ? 'diaktifkan kembali' : 'ditangguhkan (suspend)';

        return back()->with('success', "Prototype '{$prototype->project_name}' berhasil {$statusText}.");
    }

    /**
     * Delete a prototype completely.
     */
    public function destroy($id)
    {
        $prototype = Prototype::findOrFail($id);

        if (File::exists($prototype->storage_path)) {
            File::deleteDirectory($prototype->storage_path);
        }

        $prototype->delete();

        return back()->with('success', "Prototype '{$prototype->project_name}' dan seluruh berkasnya berhasil dihapus.");
    }
}
