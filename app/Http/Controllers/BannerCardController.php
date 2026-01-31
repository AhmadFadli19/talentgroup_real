<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerCardCreate;
use App\Models\BannerCardDetail;

class BannerCardController extends Controller
{
    // Menampilkan form create
    public function create()
    {
        return view('admin.content.banner.create');
    }

    public function delete($id)
    {
        $BannerCard = BannerCardCreate::find($id);
        $BannerCard->delete();
        return redirect()->back();
    }

    // Simpan data card
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'description' => 'nullable|string',
            'create_view' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'category' => 'nullable|in:freelance,mini_bootcamp,ready_bootcamp',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        $BannerCard = BannerCardCreate::create($data);

        return redirect()->route('bannercard.dynamic', ['slug' => $BannerCard->create_view])
            ->with('success', 'Card berhasil dibuat! Silakan isi detail kontennya.');
    }

    // Tampilkan form detail konten jika belum ada
    public function detailForm($id)
    {
        $BannerCard = BannerCardCreate::findOrFail($id);

        if ($BannerCard->detail) {
            return redirect()->route('bannercard.dynamic', $BannerCard->create_view)
                ->with('info', 'Detail sudah ada. Menampilkan halaman.');
        }

        return view('admin.content.banner.detail-form', compact('BannerCard'));
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
            'sasaran' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        $BannerCard = BannerCardCreate::findOrFail($id);

        BannerCardDetail::create([
            'BannerCard_id' => $BannerCard->id,
            'judul' => $request->judul,
            'image' => $request->image,
            'topic' => $request->topic,
            'url_kelas' => $request->url_kelas,
            'judul_description' => $request->judul_description,
            'description_kelas' => $request->description_kelas,
            'target' => $request->target,
            'sasaran' => $request->sasaran,
        ]);

        return redirect()->route('bannercard.dynamic', $BannerCard->create_view)
            ->with('success', 'Detail konten berhasil disimpan!');
    }

    // Menampilkan card berdasarkan slug (create_view)
    public function dynamicView($slug)
    {
        $BannerCard = BannerCardCreate::where('create_view', $slug)->with('detail')->firstOrFail();

        // Cek apakah detail benar-benar ada (bukan hanya relasi yang di-load)
        if (is_null($BannerCard->detail)) {
            return view('admin.content.banner.detail-form', compact('BannerCard'));
        }

        $BannerCardDetail = $BannerCard->detail;
        return view('admin.content.banner.show', compact('BannerCard', 'BannerCardDetail'));
    }
}
