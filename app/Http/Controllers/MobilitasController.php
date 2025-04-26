<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mobilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MobilitasController extends Controller
{
    public function indexmobilitas(Request $request)
    {
        $user = Auth::user();
        $query = Mobilitas::query();

        // Filter tanggal mingguan (Minggu s/d Sabtu)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->startOfDay();
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY)->endOfDay();

        // Jika user biasa, filter berdasarkan user_id
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            $query->where('user_id', $user->id);
        } else {
            $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
        }

        // Filter berdasarkan inputan form
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->has('keterangan') && in_array($request->keterangan, ['hadir', 'izin'])) {
            $query->where('keterangan', $request->keterangan);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pegawai', 'like', '%' . $request->search . '%');
        }

        $mobilitas = $query->latest()->get();

        // Untuk menampilkan semua hadir/izin mingguan jika admin
        $hadir = $mobilitas->where('keterangan', 'hadir');
        $izin = $mobilitas->where('keterangan', 'izin');

        return view('backend.mobilitas.index', compact('mobilitas', 'hadir', 'izin'));
    }

    public function create()
    {
        $today = Carbon::today();
        $saturday = Carbon::now()->startOfWeek()->addDays(5); // Sabtu minggu ini

        if ($today->greaterThan($saturday)) {
            Alert::toast('Form mobilitas hanya bisa diisi sampai hari Sabtu setiap minggunya.', 'error');
            return redirect()->back();
        }

        $users = User::all();
        return view('backend.mobilitas.create', compact('users'));
    }

    public function store(Request $request)
{
    try {
        // Validasi dasar
        $request->validate([
            'jam' => 'required',
            'keterangan' => 'required|in:hadir,izin',
            'file_izin' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_eviden' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Dapatkan awal minggu ini (Senin)
        $mingguIni = now()->startOfWeek();

        $mobilitas = new Mobilitas();
        $mobilitas->user_id = Auth::id();
        $mobilitas->nama_pegawai = Auth::user()->name;
        $mobilitas->hari = now()->translatedFormat('l');
        $mobilitas->jam = $request->jam;
        $mobilitas->keterangan = $request->keterangan;
        $mobilitas->status = 'verifikasi';
        $mobilitas->minggu_ke = $mingguIni; // <-- Set minggu_ke

        if ($request->keterangan === 'izin') {
            $mobilitas->alasan = $request->alasan;
            $mobilitas->jam_izin = $request->jam_izin;

            if ($request->hasFile('file_izin')) {
                $mobilitas->file_izin = $request->file('file_izin')->store('izin', 'public');
            }
        }

        if ($request->keterangan === 'hadir' && $request->hasFile('file_eviden')) {
            $mobilitas->file_eviden = $request->file('file_eviden')->store('eviden', 'public');
        }

        $mobilitas->save();

        Alert::toast('Mobilitas berhasil ditambahkan', 'success');
        return redirect()->route('backend.mobilitas.pegawa.index');
    } catch (\Exception $e) {
        Alert::toast('Gagal menambahkan mobilitas: ' . $e->getMessage(), 'error');
        return redirect()->back()->withInput();
    }
}
    public function verifikasi($id)
{
    $mobilitas = Mobilitas::findOrFail($id);
    $mobilitas->status = 'disetujui';
    $mobilitas->save();

    Alert::toast('Mobilitas berhasil disetujui.', 'success');
    return redirect()->back();
}
public function tolak($id)
{
    $mobilitas = Mobilitas::findOrFail($id);
    $mobilitas->status = 'ditolak';
    $mobilitas->save();

    Alert::toast('Mobilitas ditolak.', 'error');
    return redirect()->back();
}
}
