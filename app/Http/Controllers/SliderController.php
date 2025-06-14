<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.slider.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|image|max:2084',
                'is_active' => 'nullable|boolean'
            ]);

            $image = $request->file('image');
            $uuidName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('slider_images'), $uuidName);

            Slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $uuidName,
                'is_active' => $request->has('is_active')
            ]);

            Alert::toast('Slider berhasil ditambahkan!', 'success');
            return redirect()->route('admin.backend.silder.index');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ini alert untuk validasi error
            Alert::toast('Gagal menyimpan slider. Cek input Anda.', 'error');
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Ini alert untuk error umum
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    public function toggle($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->is_active = !$slider->is_active;
        $slider->save();

        Alert::toast('Status slider berhasil diubah!', 'success');
        return redirect()->route('admin.backend.silder.index');
    }
    public function destroy($id)
        {
        $slider = Slider::findOrFail($id);

        // Hapus gambar dari public folder jika ada
        $imagePath = public_path('slider_images/' . $slider->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $slider->delete();

       Alert::toast('Slider berhasil dihapus!', 'success');
        return back();
    }

}
