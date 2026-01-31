<?php

namespace App\Http\Controllers;

use App\Models\SlideBlogger;
use Illuminate\Http\Request;
use App\Models\SlideBloggerDetail;

class SlideBloggerController extends Controller
{
    // Menampilkan form create
    public function create()
    {
        return view('admin.content.blogger.create');
    }

    public function delete($id)
    {
        $cardblogger = SlideBlogger::findOrFail($id);
        $cardblogger->delete();

        return redirect()->back();
    }
    // Simpan data card
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'blog_author' => 'nullable|string',
            'description' => 'nullable|string',
            'create_view' => 'required|string|alpha_dash|unique:SlideBlogger,create_view'
        ]);



        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        $cardblogger = SlideBlogger::create($data);

        return redirect()->route('slideblogger.dynamic', ['slug' => $cardblogger->create_view])
            ->with('success', 'Card berhasil dibuat! Silakan isi detail kontennya.');
    }

    // Tampilkan form detail konten jika belum ada
    public function detailForm($id)
    {
        $cardblogger = SlideBlogger::findOrFail($id);

        if ($cardblogger->detail) {
            return redirect()->route('slideblogger.dynamic', $cardblogger->create_view)
                ->with('info', 'Detail sudah ada. Menampilkan halaman.');
        }

        return view('admin.content.blogger.detail-form', compact('cardblogger'));
    }

    // Simpan data detail konten
    public function submitDetail(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'judul' => 'required|string',
            'topic' => 'nullable|string',
            'url_kelas' => 'nullable|string',
            'judul_description' => 'nullable|string',
            'description_kelas' => 'nullable|string',
            'target' => 'nullable|string',
            'sasaran' => 'nullable|string'
        ]);

        $cardblogger = SlideBlogger::findOrFail($id);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }
        $data['slideBlogger_id'] = $cardblogger->id;

        SlideBloggerDetail::create($data);

        return redirect()->route('slideblogger.dynamic', $cardblogger->create_view)
            ->with('success', 'Detail konten berhasil disimpan!');
    }

    // Menampilkan card berdasarkan slug (create_view)
    public function dynamicView($slug)
    {
        $cardblogger = SlideBlogger::where('create_view', $slug)->with('detail')->firstOrFail();

        // Jika detail belum ada, tampilkan form detail
        if (!$cardblogger->detail) {
            return view('admin.content.blogger.detail-form', compact('cardblogger'));
        }

        // Jika detail sudah ada, tampilkan halaman show
        $cardbloggerdetail = $cardblogger->detail;
        return view('admin.content.blogger.show', compact('cardblogger', 'cardbloggerdetail'));
    }
}
