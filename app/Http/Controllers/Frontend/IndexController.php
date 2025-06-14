<?php

namespace App\Http\Controllers\Frontend;

use App\Models\About;
use App\Models\Slider;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function frontend()
    {
        $sliders = Slider::where('is_active', true)->get();
        $layanans = Layanan::where('status', 'aktif')->get();
        return view('frontend.index', compact('sliders', 'layanans'));
    }

    public function layanan()
    {
        $layanans = Layanan::where('status', 'aktif')
                   ->orderBy('urutan')
                   ->paginate(8);;
        return view('frontend.layanan', compact('layanans'));
    }

    public function about()
    {
        $aboutSections = About::orderBy('order', 'asc')->get();
        return view('frontend.about', compact('aboutSections'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            Mail::raw($request->message, function ($mail) use ($request) {
                $mail->from($request->email, $request->name);
                $mail->to('admin@example.com') // Ganti dengan email tujuan
                     ->subject('Contact Form Message');
            });

            return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan. Silakan coba lagi.');
        }
    }
}
