<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\User;
use App\Models\UserModuleAccess;
use App\Services\ModuleMarkdownParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Display a listing of modules.
     */
    public function index(Request $request)
    {
        $query = ModuleCategory::withCount('modules')->ordered();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('visibility')) {
            $query->where('is_public', $request->visibility === 'public');
        }

        $modules = $query->paginate(12)->withQueryString();

        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Show form to create a new module.
     */
    public function create()
    {
        return view('admin.modules.create_module');
    }

    /**
     * Store a newly created module.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:module_categories,slug',
            'description' => 'nullable|string',
            'is_public' => 'nullable|boolean',
            'referral_code' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'badge' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (ModuleCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $isPublic = $request->has('is_public') ? $request->boolean('is_public') : true;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('modules/thumbnails', 'public');
        }

        $module = ModuleCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_public' => $isPublic,
            'referral_code' => $request->referral_code ? strtoupper(trim($request->referral_code)) : null,
            'image' => $imagePath,
            'icon' => $request->icon ?: 'fas fa-book',
            'color' => $request->color ?: '#38bdf8',
            'badge' => $request->badge,
            'order' => $request->order ?? (ModuleCategory::max('order') + 1),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Modul "' . $module->name . '" berhasil dibuat!');
    }

    /**
     * Show form to edit a module.
     */
    public function edit($id)
    {
        $module = ModuleCategory::findOrFail($id);
        return view('admin.modules.edit_module', compact('module'));
    }

    /**
     * Update module.
     */
    public function update(Request $request, $id)
    {
        $module = ModuleCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:module_categories,slug,' . $id,
            'description' => 'nullable|string',
            'is_public' => 'nullable|boolean',
            'referral_code' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'badge' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $isPublic = $request->has('is_public') ? $request->boolean('is_public') : $module->is_public;

        if ($request->hasFile('image')) {
            if ($module->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($module->image);
            }
            $module->image = $request->file('image')->store('modules/thumbnails', 'public');
        }

        $module->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'is_public' => $isPublic,
            'referral_code' => $request->referral_code ? strtoupper(trim($request->referral_code)) : null,
            'icon' => $request->icon ?: 'fas fa-book',
            'color' => $request->color ?: '#38bdf8',
            'badge' => $request->badge,
            'order' => $request->order ?? $module->order,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : false,
        ]);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Modul "' . $module->name . '" berhasil diperbarui!');
    }

    /**
     * Toggle active/inactive status for a module.
     */
    public function toggleActive($id)
    {
        $module = ModuleCategory::findOrFail($id);
        $module->is_active = !$module->is_active;
        $module->save();

        $statusText = $module->is_active ? 'diaktifkan (Active)' : 'dinonaktifkan (Inactive)';
        return back()->with('success', "Status modul \"{$module->name}\" berhasil diubah menjadi {$statusText}!");
    }

    /**
     * Delete module.
     */
    public function destroy($id)
    {
        $module = ModuleCategory::findOrFail($id);
        $name = $module->name;

        if ($module->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($module->image);
        }

        $module->delete();

        return redirect()->route('admin.modules.index')
            ->with('success', 'Modul "' . $name . '" beserta seluruh materinya berhasil dihapus!');
    }

    // ============================================
    // MODULE LESSONS / CONTENTS MANAGEMENT
    // ============================================

    /**
     * Manage chapters/lessons for a specific module.
     */
    public function contentsIndex($moduleId)
    {
        $module = ModuleCategory::withCount('modules')->findOrFail($moduleId);
        $lessons = Module::where('category_id', $module->id)
            ->orderBy('section', 'asc')
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(30);

        return view('admin.modules.contents_index', compact('module', 'lessons'));
    }

    /**
     * Create lesson for a specific module.
     */
    public function contentsCreate($moduleId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $existingSections = Module::where('category_id', $module->id)
            ->whereNotNull('section')
            ->distinct()
            ->pluck('section')
            ->filter()
            ->values();

        return view('admin.modules.create_lesson', compact('module', 'existingSections'));
    }

    /**
     * Store lesson for a specific module.
     */
    public function contentsStore(Request $request, $moduleId)
    {
        $module = ModuleCategory::findOrFail($moduleId);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:100',
            'content_type' => 'nullable|string|in:markdown,pdf,word',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,md,txt|max:51200',
            'order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
            'enable_protection' => 'nullable|boolean',
        ]);

        $contentType = $request->input('content_type', 'markdown');
        $content = $request->input('content', '');
        if (str_starts_with($content, 'base64:')) {
            $decoded = base64_decode(substr($content, 7), true);
            if ($decoded !== false) {
                $content = $decoded;
            }
        }
        $filePath = null;
        $fileName = null;
        $fileSize = null;

        // Handle file upload (PDF, Word, or Markdown)
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $extension = strtolower($file->getClientOriginalExtension());

            if ($extension === 'md' || $extension === 'txt') {
                $contentType = 'markdown';
                $uploadedMarkdown = file_get_contents($file->getRealPath());
                if (!empty($uploadedMarkdown)) {
                    $content = $uploadedMarkdown;
                }
            } elseif ($extension === 'pdf') {
                $contentType = 'pdf';
                $filePath = $file->store('modules/documents', 'public');
                if (empty($content)) {
                    $content = "Dokumen Materi PDF: " . $fileName;
                }
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $contentType = 'word';
                $filePath = $file->store('modules/documents', 'public');
                if (empty($content)) {
                    $content = "Dokumen Materi Microsoft Word: " . $fileName;
                }
            }
        }

        if (empty($content) && empty($filePath)) {
            return back()->withInput()->withErrors(['content' => 'Isi materi Markdown atau unggah berkas dokumen (PDF/Word/.md) wajib diisi.']);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Module::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $section = $request->section ? strtoupper(trim($request->section)) : 'GETTING STARTED';

        $lesson = Module::create([
            'category_id' => $module->id,
            'section' => $section,
            'title' => $request->title,
            'slug' => $slug,
            'content_type' => $contentType,
            'excerpt' => $request->excerpt,
            'content' => $content,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'order' => $request->order ?? (Module::where('category_id', $module->id)->max('order') + 1),
            'is_published' => $request->has('is_published') ? $request->boolean('is_published') : true,
            'enable_protection' => $request->has('enable_protection') ? $request->boolean('enable_protection') : true,
        ]);

        return redirect()->route('admin.modules.contents.index', $module->id)
            ->with('success', 'Bab materi "' . $lesson->title . '" berhasil ditambahkan ke ' . $module->name . '!');
    }

    /**
     * Edit lesson for a specific module.
     */
    public function contentsEdit($moduleId, $contentId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $lesson = Module::where('category_id', $module->id)->findOrFail($contentId);
        $existingSections = Module::where('category_id', $module->id)
            ->whereNotNull('section')
            ->distinct()
            ->pluck('section')
            ->filter()
            ->values();

        return view('admin.modules.edit_lesson', compact('module', 'lesson', 'existingSections'));
    }

    /**
     * Update lesson for a specific module.
     */
    public function contentsUpdate(Request $request, $moduleId, $contentId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $lesson = Module::where('category_id', $module->id)->findOrFail($contentId);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:modules,slug,' . $lesson->id,
            'section' => 'nullable|string|max:100',
            'content_type' => 'nullable|string|in:markdown,pdf,word',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,md,txt|max:51200',
            'order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
            'enable_protection' => 'nullable|boolean',
        ]);

        $contentType = $request->input('content_type', $lesson->content_type ?: 'markdown');
        $content = $request->input('content', $lesson->content);
        if (str_starts_with($content, 'base64:')) {
            $decoded = base64_decode(substr($content, 7), true);
            if ($decoded !== false) {
                $content = $decoded;
            }
        }
        $filePath = $lesson->file_path;
        $fileName = $lesson->file_name;
        $fileSize = $lesson->file_size;

        if ($request->hasFile('document_file')) {
            // Delete old file if exists
            if ($lesson->file_path && Storage::disk('public')->exists($lesson->file_path)) {
                Storage::disk('public')->delete($lesson->file_path);
            }

            $file = $request->file('document_file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $extension = strtolower($file->getClientOriginalExtension());

            if ($extension === 'md' || $extension === 'txt') {
                $contentType = 'markdown';
                $uploadedMarkdown = file_get_contents($file->getRealPath());
                if (!empty($uploadedMarkdown)) {
                    $content = $uploadedMarkdown;
                }
            } elseif ($extension === 'pdf') {
                $contentType = 'pdf';
                $filePath = $file->store('modules/documents', 'public');
                if (empty($content)) {
                    $content = "Dokumen Materi PDF: " . $fileName;
                }
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $contentType = 'word';
                $filePath = $file->store('modules/documents', 'public');
                if (empty($content)) {
                    $content = "Dokumen Materi Microsoft Word: " . $fileName;
                }
            }
        }

        $section = $request->section ? strtoupper(trim($request->section)) : ($lesson->section ?: 'GETTING STARTED');

        $lesson->update([
            'section' => $section,
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content_type' => $contentType,
            'excerpt' => $request->excerpt,
            'content' => $content,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'order' => $request->order ?? $lesson->order,
            'is_published' => $request->has('is_published') ? $request->boolean('is_published') : false,
            'enable_protection' => $request->has('enable_protection') ? $request->boolean('enable_protection') : false,
        ]);

        return redirect()->route('admin.modules.contents.index', $module->id)
            ->with('success', 'Bab materi "' . $lesson->title . '" berhasil diperbarui!');
    }

    /**
     * Toggle publish status for a lesson.
     */
    public function contentsTogglePublish($moduleId, $contentId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $lesson = Module::where('category_id', $module->id)->findOrFail($contentId);
        $lesson->is_published = !$lesson->is_published;
        $lesson->save();

        $statusText = $lesson->is_published ? 'dipublikasikan (Published)' : 'disimpan sebagai draft (Draft)';
        return back()->with('success', "Materi \"{$lesson->title}\" berhasil {$statusText}!");
    }

    /**
     * Delete lesson for a specific module.
     */
    public function contentsDestroy($moduleId, $contentId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $lesson = Module::where('category_id', $module->id)->findOrFail($contentId);
        $title = $lesson->title;
        $lesson->delete();

        return redirect()->route('admin.modules.contents.index', $module->id)
            ->with('success', 'Bab materi "' . $title . '" berhasil dihapus!');
    }

    // ============================================
    // PRIVATE MODULE USER ACCESS MANAGEMENT
    // ============================================

    /**
     * Manage user access for this module.
     */
    public function accessIndex($moduleId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $accessList = UserModuleAccess::with(['user', 'grantedBy'])
            ->where('category_id', $module->id)
            ->latest()
            ->paginate(20);

        $users = User::orderBy('name', 'asc')->get(['id', 'name', 'email', 'username']);

        return view('admin.modules.access_index', compact('module', 'accessList', 'users'));
    }

    /**
     * Grant manual access to a user.
     */
    public function accessGrant(Request $request, $moduleId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        UserModuleAccess::updateOrCreate(
            [
                'user_id' => $user->id,
                'category_id' => $module->id,
            ],
            [
                'access_method' => 'admin_manual',
                'granted_by' => auth()->id(),
            ]
        );

        return redirect()->route('admin.modules.access.index', $module->id)
            ->with('success', 'Akses ke modul ' . $module->name . ' berhasil diberikan kepada ' . $user->name . '!');
    }

    /**
     * Revoke access.
     */
    public function accessRevoke($moduleId, $accessId)
    {
        $module = ModuleCategory::findOrFail($moduleId);
        $access = UserModuleAccess::where('category_id', $module->id)->findOrFail($accessId);
        $userName = $access->user ? $access->user->name : 'User';
        $access->delete();

        return redirect()->route('admin.modules.access.index', $module->id)
            ->with('success', 'Akses modul untuk ' . $userName . ' berhasil dicabut.');
    }

    /**
     * AJAX Live Markdown Preview.
     */
    public function preview(Request $request)
    {
        $content = $request->input('content', '');
        $renderedHtml = ModuleMarkdownParser::parse($content);
        $toc = ModuleMarkdownParser::extractTableOfContents($content);

        return response()->json([
            'html' => $renderedHtml,
            'toc' => $toc,
        ]);
    }

    /**
     * AJAX Image Upload in CMS Editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('modules/images', 'public');
            $url = Storage::url($path);

            return response()->json([
                'success' => true,
                'url' => asset($url),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Upload gagal'], 400);
    }
}
