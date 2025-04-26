<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mobilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobilitasReportController extends Controller
{


public function chartData()
{
    $data = Mobilitas::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
            'nama_pegawai',
            'keterangan',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('bulan', 'nama_pegawai', 'keterangan')
        ->orderBy('bulan')
        ->get();

    $groupedData = [];

    foreach ($data as $item) {
        $bulan = $item->bulan;
        $nama = $item->nama_pegawai;
        $keterangan = $item->keterangan;

        $groupedData[$nama][$keterangan][$bulan] = $item->total;
    }

    return response()->json($groupedData);
}

}
