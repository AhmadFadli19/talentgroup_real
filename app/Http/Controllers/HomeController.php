<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardDetail;
use App\Models\Kolaborasi;
use App\Models\Slidebanner;
use App\Models\SlideBlogger;
use Illuminate\Http\Request;
use App\Models\BannerCardCreate;

class HomeController extends Controller
{
    public function index() {
        $slidecard = Card::all();
        $kolaborasi = Kolaborasi::all();
        $slidebanner = Slidebanner::all();
        $bannerCard = BannerCardCreate::all();
        $slideblogger = SlideBlogger::all();
        return view('Home/index', compact('slidecard', 'slidebanner', 'bannerCard', 'kolaborasi','slideblogger'));
    }


    public function about() {
        return view('Home/about');
    }

    public function blog() {
        $slideblogger = SlideBlogger::all();
        return view('Home/blog', compact('slideblogger'));
    }

    public function partnerkolaborasi() {
        $kolaborasi = Kolaborasi::all();
        return view('Home/partnerkolaborasi', compact('kolaborasi'));
    }
}
