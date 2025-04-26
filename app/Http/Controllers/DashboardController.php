<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mobilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
{
    $user = Auth::user();

    // Jika admin atau superadmin, ambil data untuk seluruh pengguna
    if ($user->role === 'admin' || $user->role === 'superadmin') {
        $mobilitas = Mobilitas::all();
    } else {
        // Jika bukan admin, hanya ambil data mobilitas untuk user yang login
        $mobilitas = Mobilitas::where('user_id', $user->id)->get();
    }

    $mobilitasuser = Mobilitas::where('user_id', $user->id)->count();
    // Hitung jumlah hadir dan izin berdasarkan keterangan dan user_id
    $hadirCount = $mobilitas->where('keterangan', 'hadir')->groupBy('user_id')->map(function ($group) {
        return $group->count();
    });

    $izinCount = $mobilitas->where('keterangan', 'izin')->groupBy('user_id')->map(function ($group) {
        return $group->count();
    });

    // Total user yang terdaftar
    $usertotal = User::count();

    // Data untuk Pie Chart
    $chartData = [];
    if ($user->role === 'admin' || $user->role === 'superadmin') {
        // Untuk admin/superadmin, tampilkan data untuk seluruh pengguna
        $chartData = [
            'hadir' => $hadirCount->sum(),
            'izin' => $izinCount->sum(),
        ];
    } else {
        // Untuk user, tampilkan data untuk mereka sendiri
        $chartData = [
            'hadir' => $hadirCount[$user->id] ?? 0,
            'izin' => $izinCount[$user->id] ?? 0,
        ];
    }

    // Mengirimkan data ke view
    return view('dashboard', compact('usertotal', 'mobilitasuser', 'hadirCount', 'izinCount', 'chartData', 'mobilitasuser'));
}

public function chartpie()
{
    $user = Auth::user();

    // Data mobilitas berdasarkan role
    if ($user->role === 'admin' || $user->role === 'superadmin') {
        // Ambil data seluruh pengguna untuk admin
        $hadirCount = Mobilitas::where('keterangan', 'hadir')->count();
        $izinCount = Mobilitas::where('keterangan', 'izin')->count();
    } else {
        // Ambil data hanya untuk user yang login
        $hadirCount = Mobilitas::where('user_id', $user->id)->where('keterangan', 'hadir')->count();
        $izinCount = Mobilitas::where('user_id', $user->id)->where('keterangan', 'izin')->count();
    }

    // Menyiapkan data untuk Pie Chart
    $chartData = [
        'hadir' => $hadirCount,
        'izin' => $izinCount,
    ];

    // Total user yang terdaftar
    $usertotal = User::count();

    return response()->json([
        'hadir' => $hadirCount,
        'izin' => $izinCount,

    ]);
}

}
