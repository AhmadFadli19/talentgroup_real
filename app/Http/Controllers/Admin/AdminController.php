<?php

namespace App\Http\Controllers\Admin;

use App\Models\CardDetail;
use App\Models\Slidebanner;
use App\Models\SlideBlogger;
use Illuminate\Http\Request;
use App\Models\BannerCardDetail;
use App\Models\KolaborasiDetail;
use App\Models\User; // jika butuh
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::where('role_id', 2)->count(); // Only count regular users
        return view('admin.index', compact('userCount'));
    }

    public function delete(Request $request, $id) {
        $slidebanner = Slidebanner::find($id);
        $slidebanner->delete();
        return redirect()->back();
    }

    public function content()
    {
        $userCount = User::where('role_id', 2)->count(); // Only count regular users
        $slidebanner = Slidebanner::all();
        $bannercard = BannerCardDetail::all();
        $kolaborasi = KolaborasiDetail::all();
        $card = CardDetail::all();  
        $blogger = SlideBlogger::all();
        return view('admin.content.index ', compact('userCount','slidebanner','bannercard','kolaborasi','card','blogger'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'string|max:255',
            'topic' => 'string|max:255',
            'url_kelas' => 'string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename, 'public');
            $data['image'] = $path;
        }

        Slidebanner::create($data);
        return redirect()->back();
    }

    public function kelolaakun()
    {
        $SemuaAkun = User::with('role')->get();
        $TotalAkunAdmin = User::where('role_id', 1)->count();
        $TotalAkunUser = User::where('role_id', 2)->count();
        $TotalAkunBank = User::where('role_id', 3)->count(); // Developer/bank

        return view('admin.KelolaAkun', compact(
            'SemuaAkun',
            'TotalAkunAdmin',
            'TotalAkunUser',
            'TotalAkunBank'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $data_user = User::where('name', 'like', "%$search%")->get();

        $SemuaAkun = User::all();
        $TotalAkunAdmin = User::where('role_id', 1)->count();
        $TotalAkunUser = User::where('role_id', 2)->count();
        $TotalAkunBank = User::where('role_id', 3)->count();

        return view('admin.KelolaAkun', [
            'SemuaAkun' => $data_user
        ], compact('data_user', 'TotalAkunAdmin', 'TotalAkunUser', 'TotalAkunBank', 'SemuaAkun'));
    }

    public function registar_proses(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('admin-kelolaakun');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin-kelolaakun');
    }

    public function akun_delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin-kelolaakun');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('/')->with('success', 'Kamu berhasil logout');
    }

    public function registar()
    {
        return view('auth.registar');
    }
}
