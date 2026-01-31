<?php

namespace App\Http\Controllers;

use App\Models\Kolaborasi;
use Illuminate\Http\Request;
use App\Models\KolaborasiDetail;

class KolaborasiController extends Controller
{
    // Menampilkan form create
    public function create()
    {
        return view('admin.content.kolaborasi.create');
    }

    // Simpan data card
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'description' => 'nullable|string',
            'create_view' => 'nullable|string|alpha_dash|unique:kolaborasi,create_view',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'category' => 'nullable|in:Upbanner,Downbanner',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        $kolaborasi = Kolaborasi::create($data);

        return redirect()->route('kolaborasi.dynamic', ['slug' => $kolaborasi->create_view])
            ->with('success', 'Card berhasil dibuat! Silakan isi detail kontennya.');
    }

    public function delete($id) {
        $kolaborasi = Kolaborasi::find($id);
        $kolaborasi->delete();

        return redirect()->back();

    }

    // Tampilkan form detail konten jika belum ada
    public function detailForm($id)
    {
        $kolaborasi = Kolaborasi::findOrFail($id);

        if ($kolaborasi->detail) {
            return redirect()->route('kolaborasi.dynamic', $kolaborasi->create_view)
                ->with('info', 'Detail sudah ada. Menampilkan halaman.');
        }

        return view('admin.content.kolaborasi.detail-form', compact('kolaborasi'));
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

        $kolaborasi = Kolaborasi::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        $data['kolaborasi_id'] = $kolaborasi->id;

        KolaborasiDetail::create($data);

        return redirect()->route('kolaborasi.dynamic', $kolaborasi->create_view)
            ->with('success', 'Detail konten berhasil disimpan!');
    }

    // Menampilkan card berdasarkan slug (create_view)
    public function dynamicView($slug)
    {
        $kolaborasi = Kolaborasi::where('create_view', $slug)->with('detail')->firstOrFail();

        // Jika detail belum ada, tampilkan form detail
        if (!$kolaborasi->detail) {
            return view('admin.content.kolaborasi.detail-form', compact('kolaborasi'));
        }

        // Jika detail sudah ada, tampilkan halaman show
        $kolaborasidetail = $kolaborasi->detail;
        return view('admin.content.kolaborasi.show', compact('kolaborasi', 'kolaborasidetail'));
    }
}
