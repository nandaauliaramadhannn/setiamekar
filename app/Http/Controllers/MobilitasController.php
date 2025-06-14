<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mobilitas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MobilitasHistory;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MobilitasController extends Controller
{
    public function indexmobilitas(Request $request)
    {
        $user = Auth::user();
        $query = Mobilitas::query();

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->startOfDay();
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY)->endOfDay();

        if (!in_array($user->role, ['admin', 'superadmin'])) {
            $query->where('user_id', $user->id);
        } else {
            $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
        }

        // Filter tambahan
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('keterangan') && in_array($request->keterangan, ['hadir', 'izin'])) {
            $query->where('keterangan', $request->keterangan);
        }

        if ($request->filled('search')) {
            $query->where('nama_pegawai', 'like', '%' . $request->search . '%');
        }

        $mobilitas = $query->latest()->get();
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
        $request->validate([
            'jam' => 'required',
            'keterangan' => 'required|in:hadir,izin',
            'file_izin' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_eviden' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $mobilitas = new Mobilitas();
        $mobilitas->user_id = Auth::id();
        $mobilitas->nama_pegawai = Auth::user()->name;
        $mobilitas->hari = now()->translatedFormat('l');
        $mobilitas->jam = Carbon::createFromFormat('H:i', $request->jam)->format('H.i');
        $mobilitas->keterangan = $request->keterangan;
        $mobilitas->nama_kegiatan = $request->nama_kegiatan;
        $mobilitas->lokasi = $request->lokasi;
        $mobilitas->status = 'verifikasi';
        $mobilitas->minggu_ke = now()->startOfWeek();

        // Pastikan folder upload/data/doc ada
        $uploadPath = public_path('upload/data/doc');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        if ($request->keterangan === 'izin') {
            $mobilitas->alasan = $request->alasan;
            $mobilitas->jam_izin = $request->jam_izin;

            if ($request->hasFile('file_izin')) {
                $file = $request->file('file_izin');
                $fileName = time() . '_izin_' . $file->getClientOriginalName();
                $file->move($uploadPath, $fileName);
                $mobilitas->file_izin = 'upload/data/doc/' . $fileName;
            }
        }

        if ($request->keterangan === 'hadir' && $request->hasFile('file_eviden')) {
            $file = $request->file('file_eviden');
            $fileName = time() . '_eviden_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fileName);
            $mobilitas->file_eviden = 'upload/data/doc/' . $fileName;
        }

        $mobilitas->save();

        Alert::toast('Mobilitas berhasil ditambahkan.', 'success');
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

        Alert::toast('Mobilitas berhasil ditolak.', 'error');
        return redirect()->back();
    }

    public function show($id)
    {
        $mobilitas = Mobilitas::with('histories.pegawaiAwal', 'histories.pegawaiPengganti', 'histories.updater')->findOrFail($id);
        return view('backend.mobilitas.show', compact('mobilitas'));
    }

    public function edit($id)
    {
        $mobilitas = Mobilitas::findOrFail($id);
        $pegawai = User::where('role', 'user')->get(); // Hanya pegawai biasa (jika ada role)

        return view('backend.mobilitas.edit', compact('mobilitas', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $mobilitas = Mobilitas::findOrFail($id);

        $mobilitas->status = $request->status;

        // Kalau admin pilih pengganti
        if ($request->pegawai_pengganti_id) {
            // Simpan history penunjukan
            MobilitasHistory::create([
                'mobilitas_id' => $mobilitas->id,
                'pegawai_awal_id' => $mobilitas->user_id,
                'pegawai_pengganti_id' => $request->pegawai_pengganti_id,
                'updated_by' => Auth::id(),
                'keterangan' => $request->keterangan_history,
            ]);

            // Update pegawai mobilitas (diganti)
            $mobilitas->user_id = $request->pegawai_pengganti_id;
        }

        $mobilitas->save();

        return redirect()->route('backend.mobilitas.pegawa.index')->with('success', 'Data mobilitas berhasil diperbarui.');
    }

    public function report(Request $request)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startOfWeek = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endOfWeek = \Carbon\Carbon::parse($request->end_date)->endOfDay();
        }

        $mobilitas = Mobilitas::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();

        return view('backend.mobilitas.report', compact('mobilitas', 'startOfWeek', 'endOfWeek'));
    }
    public function reportPdf(Request $request)
{
    $startOfWeek = now()->startOfWeek();
    $endOfWeek = now()->endOfWeek();

    if ($request->has('start_date') && $request->has('end_date')) {
        $startOfWeek = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $endOfWeek = \Carbon\Carbon::parse($request->end_date)->endOfDay();
    }

    // Ambil mobilitas + relasi history penunjukan
    $mobilitas = Mobilitas::with('histories.pegawaiAwal', 'histories.pegawaiPengganti', 'histories.updater')
        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        ->get();

    $pdf = Pdf::loadView('backend.mobilitas.report-pdf', compact('mobilitas', 'startOfWeek', 'endOfWeek'))
            ->setPaper('A4', 'landscape'); // Supaya tabel lebih lebar

    return $pdf->download('laporan-mobilitas-' . now()->format('d-m-Y') . '.pdf');
}
}
