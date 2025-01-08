@extends('layouts.app')

@section('title')
Administrasi Normal | HIPPAM Admin
@endsection

@section('content')
<h3>Administrasi Normal</h3>
<button type="button" class="btn btn-tambah">
  <a href="/normal/tambah">
  <span class="tambah_name">Tambah Data</span>
  </a>
</button>
<div class="table-controls">
<form action="{{ route('normal.index') }}" method="GET" class="search-form">
    <input type="text" name="search" placeholder="Cari berdasarkan Nama" value="{{ request('search') }}">
    <input type="hidden" name="sort" value="{{ request('sort', 'desc') }}">
    <button type="submit" class="btn btn-cari">
    <span class="cari_name">Cari</span>
    </button>
</form>
</div>
<table class="table-data">
  <thead>
    <tr>
      <th style="color: white">Nama</th>
      <th style="color: white">Alamat</th>
      <th style="color: white">Bulan/Tahun</th>
      <th style="color: white">Harga Air</th>
      <th style="color: white">Total Pembayaran</th>
      <th style="color: white">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($normal as $normal)
    <tr>
      <td>{{ $normal->nama }}</td>
      <td>{{ $normal->alamat }}</td>
      <td>{{ $normal->bln_thn }}</td>
      <td>{{ $normal->harga_air }}</td>
      <td>{{ $normal->total_byr }}</td>
      <td>

      <button type="button" class="btncetak">
      <a href="/normal/downloadpdf/{{$normal->id }}">
        <span class="cetak_name">CETAK</span>
      </a>
      </button>

      <button type="button" class="btnedit">
      <a href="/normal/edit/{{ $normal->id }}">
        <span class="edit_name">EDIT</span>
      </a>
      </button>

      <button type="button" class="btnhapus">
      <a href="/normal/hapus/{{ $normal->id }}">
        <span class="hapus_name">HAPUS</span>
      </a>
      </button>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="6" align="center">Tidak ada data</td>
    </tr>
    @endforelse
  </tbody>
</table>
@endsection
