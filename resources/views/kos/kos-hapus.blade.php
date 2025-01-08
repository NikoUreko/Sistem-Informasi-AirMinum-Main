@extends('layouts.app')

@section('title')
Hapus Food | Chillin'Vibe Admin
@endsection

@section('content')
<h3>Hapus Food</h3>
<div class="form-login">
<h4>Ingin Menghapus Data ?</h4>

  <button type="submit" class="btn btn-simpan" style="width: 40%; margin: 20px auto;" onclick="navigateTo('{{ url('/kos/destroy/' . $kos->id ) }}')">
  <span class="simpan_name">Ya</span>
  </button>

  <button type="submit" class="btn btn-simpan" style="width: 40%; margin: 20px auto;" onclick="navigateTo('/kos')">
  <span class="simpan_name">Batal</span>
  </button>

</div>

<script>
function navigateTo(url) {
    window.location.href = url;
}
</script>

@endsection
