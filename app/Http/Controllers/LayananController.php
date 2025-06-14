<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::orderBy('urutan')->get();
        return view('backend.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('backend.layanan.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:100',
        'ikon' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string',
        'urutan' => 'nullable|integer',
        'status' => 'required|in:aktif,nonaktif',
    ]);

    try {
        Layanan::create([
            'nama' => $request->nama,
            'ikon' => $request->ikon,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
            'status' => $request->status,
        ]);

        Alert::toast('Layanan berhasil ditambahkan!', 'success')->autoClose(3000);
        return redirect()->route('admin.backend.index.layanan');
    } catch (\Exception $e) {
        // Log error untuk debugging (opsional)
        Log::error('Gagal menambahkan layanan: ' . $e->getMessage());

        Alert::toast('Terjadi kesalahan saat menyimpan data!' . $e->getMessage(), 'error')->autoClose(3000);
        return back()->withInput();
    }
}

public function destroy($id)
{
    try {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        Alert::toast('Layanan berhasil dihapus!', 'success')->autoClose(3000);
        return redirect()->route('admin.backend.index.layanan');
    } catch (\Exception $e) {
        // Log error untuk debugging (opsional)
        Log::error('Gagal menghapus layanan: ' . $e->getMessage());

        Alert::toast('Terjadi kesalahan saat menghapus data!' . $e->getMessage(), 'error')->autoClose(3000);
        return back();
    }
}
}
