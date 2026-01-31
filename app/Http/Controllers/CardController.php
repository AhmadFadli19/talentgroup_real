<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardDetail;
use App\Models\Kolaborasi;
use Illuminate\Http\Request;

class CardController extends Controller
{
    // Menampilkan form create
    public function create()
    {
        return view('admin.content.cards.create');
    }

    public function delete($id)
    {
        $kolaborasi = Kolaborasi::find($id);
        $kolaborasi->delete();

        return redirect()->back();
    }

    // Simpan data card
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'price' => 'nullable|string',
            'create_view' => 'required|string|alpha_dash|unique:cards,create_view',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'certificate' => 'required|in:ya,tidak',
            'best_seller' => 'nullable',
        ]);

        $data['best_seller'] = $request->has('best_seller');
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        $card = Card::create($data);

        return redirect()->route('cards.dynamic', ['slug' => $card->create_view])
            ->with('success', 'Card berhasil dibuat! Silakan isi detail kontennya.');
    }

    // Tampilkan form detail konten jika belum ada
    public function detailForm($id)
    {
        $card = Card::findOrFail($id);

        if ($card->detail) {
            return redirect()->route('cards.dynamic', $card->create_view)
                ->with('info', 'Detail sudah ada. Menampilkan halaman.');
        }

        return view('admin.content.cards.detail-form', compact('card'));
    }

    // Simpan data detail konten
    public function submitDetail(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'judul' => 'required|string',
            'topic' => 'nullable|string',
            'url_kelas' => 'nullable|string',
            'jam_kelas' => 'nullable|string',
            'judul_description' => 'nullable|string',
            'description_kelas' =>'nullable|string',
            'target' =>'nullable|string',
            'sasaran' =>'nullable|string',
            'metode_pembelajaran' =>'nullable|string',
            'materi_pembelajaran' =>'nullable|string',
            'persiapan_pembelajaran' =>'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        $card = Card::findOrFail($id);

        CardDetail::create([
            'card_id' => $card->id,
            'image' => $request->image,
            'judul' => $request->judul,
            'topic' => $request->topic,
            'url_kelas' => $request->url_kelas,
            'jam_kelas' => $request->jam_kelas,
            'judul_description' => $request->judul_description,
            'description_kelas' => $request->description_kelas,
            'target' => $request->target,
            'sasaran' => $request->sasaran,
            'metode_pembelajaran' => $request->metode_pembelajaran,
            'materi_pembelajaran' => $request->materi_pembelajaran,
            'persiapan_pembelajaran' => $request->persiapan_pembelajaran
        ]);

        return redirect()->route('cards.dynamic', $card->create_view)
            ->with('success', 'Detail konten berhasil disimpan!');
    }

    // Menampilkan card berdasarkan slug (create_view)
    public function dynamicView($slug)
    {
        $card = Card::where('create_view', $slug)->with('detail')->firstOrFail();
        $carddetail = CardDetail::where('card_id', $card->id)->firstOrFail();

        // Cek apakah detail benar-benar ada (bukan hanya relasi yang di-load)
        if (is_null($card->detail)) {
            return view('admin.content.cards.detail-form', compact('card'));
        }

        $carddetail = $card->detail;
        return view('admin.content.cards.show', compact('card', 'carddetail'));
    }
}
