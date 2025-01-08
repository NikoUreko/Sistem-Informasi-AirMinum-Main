<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PDF;

class VillaController extends Controller
{
    public function index(Request $request)
{
    
    $search = $request->input('search');

    
    if ($search) {
        $villa = Villa::query()
            ->where('nama', 'like', '%' . $search . '%') 
            ->orderBy('bln_thn', 'desc') 
            ->get();
    } else {
        
        $villa = Villa::query()
            ->orderBy('updated_at', 'desc') 
            ->get();
    }

    
    return view('villa.villa', compact('villa', 'search'));
}

    public function downloadpdf($id) {
        $villa = Villa::find($id); 
        if (!$villa) {
            return redirect('/villa')->with('error', 'Data tidak ditemukan');
        }
        $pdf = PDF::loadview('villa.villa-pdf', ['villa' => $villa])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('laporan_villa.pdf');
    }

    public function create()
    {
        return view('villa.villa-entry');
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
    $kuotaLevel = [10, 10, 10000]; // Kuota maksimal untuk masing-masing level
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
    $tarif = [1000, 2500, 3500]; // Tarif per level
    $tarifLevel1 = $pemakaianLevel[0] * $tarif[0];
    $tarifLevel2 = $pemakaianLevel[1] * $tarif[1];
    $tarifLevel3 = $pemakaianLevel[2] * $tarif[2];

    $totalHargaAir = $tarifLevel1 + $tarifLevel2 + $tarifLevel3;

    // Tambahkan sewa meter
    $sewa_M = $request->sewa_M;
    $totalBayar = $totalHargaAir + $sewa_M;

    // Tambahkan denda jika berlaku
    if ($request->denda === 'iya') {
        $totalBayar += 5000;
    } else if ($request->denda === 'iya2') {
        $totalBayar += 10000;
    }

    
    Villa::create([
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
        'harga_air' => $totalHargaAir,
        'sewa_M' => $sewa_M,
        'denda' => $request->denda,
        'total_byr' => $totalBayar,
    ]);

    return redirect('/villa')->with('success', 'Data pelanggan berhasil ditambahkan!');
}



public function edit($id)
{
    $villa = Villa::find($id);
    return view('villa.villa-edit', compact('villa'));
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
    $kuotaLevel = [10, 10, 10000]; // Kuota maksimal untuk masing-masing level
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
    $tarif = [1000, 2500, 3500]; // Tarif per level
    $tarifLevel1 = $pemakaianLevel[0] * $tarif[0];
    $tarifLevel2 = $pemakaianLevel[1] * $tarif[1];
    $tarifLevel3 = $pemakaianLevel[2] * $tarif[2];

    $totalHargaAir = $tarifLevel1 + $tarifLevel2 + $tarifLevel3;

    // Tambahkan sewa meter
    $sewa_M = $request->sewa_M;
    $totalBayar = $totalHargaAir + $sewa_M;

    // Tambahkan denda jika berlaku
    if ($request->denda === 'iya') {
        $totalBayar += 5000;
    } else if ($request->denda === 'iya2') {
        $totalBayar += 10000;
    }

    // Cari data yang akan diupdate
    $villa = Villa::find($id);

    // Update data
    $villa->update([
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
        'harga_air' => $totalHargaAir,
        'sewa_M' => $sewa_M,
        'denda' => $request->denda,
        'total_byr' => $totalBayar,
    ]);

    return redirect('/villa')->with('success', 'Data pelanggan berhasil diperbarui!');
}

    public function delete($id)
    {
        $villa = Villa::find($id);
        return view('villa.villa-hapus', compact('villa'));
    }

    public function destroy($id)
{
    try {
        $villa = Villa::find($id);

        if (!$villa) {
            
            return redirect('/villa')->with('error', 'Data tidak ditemukan');
        }

        $villa->delete();

        return redirect('/villa')->with('success', 'Data berhasil dihapus');
    } catch (\Exception $e) {
        
        return redirect('/villa')->with('error', 'Terjadi kesalahan saat menghapus data');
    }
}


}