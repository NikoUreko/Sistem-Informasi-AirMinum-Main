<?php

namespace App\Http\Controllers;

use App\Models\Normal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PDF;

class NormalController extends Controller
{
    public function index(Request $request)
{
    
    $search = $request->input('search');

    
    if ($search) {
        $normal = Normal::query()
            ->where('nama', 'like', '%' . $search . '%') 
            ->orderBy('bln_thn', 'desc') 
            ->get();
    } else {
        
        $normal = Normal::query()
            ->orderBy('updated_at', 'desc') 
            ->get();
    }

    
    return view('normal.normal', compact('normal', 'search'));
}



    public function downloadpdf($id) {
        $normal = Normal::find($id); 
        if (!$normal) {
            return redirect('/normal')->with('error', 'Data tidak ditemukan');
        }
        $pdf = PDF::loadview('normal.normal-pdf', ['normal' => $normal])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('laporan_normal.pdf');
    }

    public function create()
    {
        return view('normal.normal-entry');
    }

    public function store(Request $request)
{
    // Validasi input
    $this->validate($request, [
        'nama' => 'required',
        'alamat' => 'required',
        'bln_thn' => 'required|date',
        'no_meterblnini' => 'required|integer|min:0',
        'no_meterblnlalu' => 'required|integer|min:0',
        'sewa_M' => 'required|integer|min:0',
        'denda' => 'required|in:iya,iya2,tidak',
    ]);

    // Hitung Pemakaian M
    $noMeterBlnIni = $request->no_meterblnini;
    $noMeterBlnLalu = $request->no_meterblnlalu;
    $pemakaian_M = $noMeterBlnIni - $noMeterBlnLalu;

    // Pastikan pemakaian tidak negatif
    if ($pemakaian_M < 0) {
        return back()->withErrors(['pemakaian_M' => 'Pemakaian tidak boleh negatif.'])->withInput();
    }

    // Kuota per level
    $kuotaLevel = [15, 15, 15, 10000]; // Kuota maksimal untuk masing-masing level
    $pemakaianLevel = [];
    $sisa = $pemakaian_M;

    foreach ($kuotaLevel as $kuota) {
        if ($sisa > 0) {
            $pemakaianLevel[] = min($sisa, $kuota);
            $sisa -= $kuota;
        } else {
            $pemakaianLevel[] = 0;
        }
    }

    // Hitung tarif berdasarkan level
    $tarif = [250, 500, 750, 1000]; // Tarif per level
    $tarifLevel1 = $pemakaianLevel[0] * $tarif[0];
    $tarifLevel2 = $pemakaianLevel[1] * $tarif[1];
    $tarifLevel3 = $pemakaianLevel[2] * $tarif[2];
    $tarifLevel4 = $pemakaianLevel[3] * $tarif[3];

    $totalHargaAir = $tarifLevel1 + $tarifLevel2 + $tarifLevel3 + $tarifLevel4;

    // Tambahkan sewa meter
    $sewa_M = 2500;
    $totalBayar = $totalHargaAir + $sewa_M;

    // Tambahkan denda jika berlaku
    if ($request->denda === 'iya') {
        $totalBayar += 5000;
    } else if ($request->denda === 'iya2') {
        $totalBayar += 10000;
    }

    
    Normal::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'bln_thn' => $request->bln_thn,
        'no_meterblnini' => $request->no_meterblnini,
        'no_meterblnlalu' => $request->no_meterblnlalu,
        'pemakaian_M' => $pemakaian_M,
        'pemakaian_1' => $pemakaianLevel[0],
        'tarif_I' => $tarifLevel1,
        'pemakaian_2' => $pemakaianLevel[1],
        'tarif_II' => $tarifLevel2,
        'pemakaian_3' => $pemakaianLevel[2],
        'tarif_III' => $tarifLevel3,
        'pemakaian_4' => $pemakaianLevel[3],
        'tarif_IV' => $tarifLevel4,
        'harga_air' => $totalHargaAir,
        'sewa_M' => $sewa_M,
        'denda' => $request->denda,
        'total_byr' => $totalBayar,
    ]);

    return redirect('/normal')->with('success', 'Data pelanggan berhasil ditambahkan!');
}



public function edit($id)
{
    $normal = Normal::find($id);
    return view('normal.normal-edit', compact('normal'));
}

public function update(Request $request, $id)
{
    // Validasi input
    $this->validate($request, [
        'nama' => 'required',
        'alamat' => 'required',
        'bln_thn' => 'required|date',
        'no_meterblnini' => 'required|integer|min:0',
        'no_meterblnlalu' => 'required|integer|min:0',
        'sewa_M' => 'required|integer|min:0',
        'denda' => 'required|in:iya,iya2,tidak',
    ]);

    // Hitung Pemakaian M
    $noMeterBlnIni = $request->no_meterblnini;
    $noMeterBlnLalu = $request->no_meterblnlalu;
    $pemakaian_M = $noMeterBlnIni - $noMeterBlnLalu;

    // Pastikan pemakaian tidak negatif
    if ($pemakaian_M < 0) {
        return back()->withErrors(['pemakaian_M' => 'Pemakaian tidak boleh negatif.'])->withInput();
    }

    // Kuota per level
    $kuotaLevel = [15, 15, 15, 10000]; // Kuota maksimal untuk masing-masing level
    $pemakaianLevel = [];
    $sisa = $pemakaian_M;

    foreach ($kuotaLevel as $kuota) {
        if ($sisa > 0) {
            $pemakaianLevel[] = min($sisa, $kuota);
            $sisa -= $kuota;
        } else {
            $pemakaianLevel[] = 0;
        }
    }

    // Hitung tarif berdasarkan level
    $tarif = [250, 500, 750, 1000]; // Tarif per level
    $tarifLevel1 = $pemakaianLevel[0] * $tarif[0];
    $tarifLevel2 = $pemakaianLevel[1] * $tarif[1];
    $tarifLevel3 = $pemakaianLevel[2] * $tarif[2];
    $tarifLevel4 = $pemakaianLevel[3] * $tarif[3];

    $totalHargaAir = $tarifLevel1 + $tarifLevel2 + $tarifLevel3 + $tarifLevel4;

    // Tambahkan sewa meter
    $sewa_M = 2500;
    $totalBayar = $totalHargaAir + $sewa_M;

    // Tambahkan denda jika berlaku
    if ($request->denda === 'iya') {
        $totalBayar += 5000;
    } else if ($request->denda === 'iya2') {
        $totalBayar += 10000;
    }

    // Cari data yang akan diupdate
    $normal = Normal::find($id);

    // Update data
    $normal->update([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'bln_thn' => $request->bln_thn,
        'no_meterblnini' => $request->no_meterblnini,
        'no_meterblnlalu' => $request->no_meterblnlalu,
        'pemakaian_M' => $pemakaian_M,
        'pemakaian_1' => $pemakaianLevel[0],
        'tarif_I' => $tarifLevel1,
        'pemakaian_2' => $pemakaianLevel[1],
        'tarif_II' => $tarifLevel2,
        'pemakaian_3' => $pemakaianLevel[2],
        'tarif_III' => $tarifLevel3,
        'pemakaian_4' => $pemakaianLevel[3],
        'tarif_IV' => $tarifLevel4,
        'harga_air' => $totalHargaAir,
        'sewa_M' => $sewa_M,
        'denda' => $request->denda,
        'total_byr' => $totalBayar,
    ]);

    return redirect('/normal')->with('success', 'Data pelanggan berhasil diperbarui!');
}


    public function delete($id)
    {
        $normal = Normal::find($id);
        return view('normal.normal-hapus', compact('normal'));
    }

    public function destroy($id)
{
    try {
        $normal = Normal::find($id);

        if (!$normal) {
            
            return redirect('/normal')->with('error', 'Data tidak ditemukan');
        }

        $normal->delete();

        return redirect('/normal')->with('success', 'Data berhasil dihapus');
    } catch (\Exception $e) {
        
        return redirect('/normal')->with('error', 'Terjadi kesalahan saat menghapus data');
    }
}



}