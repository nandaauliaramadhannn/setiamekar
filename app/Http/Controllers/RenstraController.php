<?php

namespace App\Http\Controllers;


use App\Models\Renstra;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RenstraController extends Controller
{
    public function indexrenstra()
{
    $allRenstra = Renstra::latest()->get();
    $renstra = Renstra::latest()->first();
    $sheetsData = [];

    // Ambil sheets data dokumen terbaru
    if ($renstra && $renstra->file) {
        $path = public_path('document/renstra/' . $renstra->file);
        if (File::exists($path)) {
            $spreadsheet = IOFactory::load($path);
            foreach ($spreadsheet->getSheetNames() as $index => $sheetName) {
                $sheet = $spreadsheet->getSheet($index);
                $sheetsData[$sheetName] = $sheet->toArray();
            }
        }
    }

    // Buat array file URL untuk semua dokumen
    $fileUrls = [];
    foreach ($allRenstra as $doc) {
        $filePath = public_path('document/renstra/' . $doc->file);
        if (File::exists($filePath)) {
            $fileUrls[$doc->id] = asset('document/renstra/' . $doc->file);
        }
    }

    return view('backend.renstra.index', compact('renstra', 'sheetsData', 'allRenstra', 'fileUrls'));
}
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $filename = 'renstra_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $destination = public_path('document/renstra');

        // Buat folder jika belum ada
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Pindahkan file
        $file->move($destination, $filename);

        // Simpan ke database
        Renstra::create([
            'file' => $filename
        ]);
        Alert::toast('File berhasil diupload!', 'success');
        return redirect()->route('backend.index.renstra');
    }

    public function destroy($id)
{
    $renstra = Renstra::findOrFail($id);

    // Hapus file fisik jika ada
    if ($renstra->file && Storage::exists($renstra->file)) {
        Storage::delete($renstra->file);
    }

    // Hapus data di DB
    $renstra->delete();
    Alert::toast('File berhasil dihapus!', 'success');
    return redirect()->back();
}
}
