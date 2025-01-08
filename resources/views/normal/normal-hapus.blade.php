@extends('layouts.app')

@section('title')
Hapus Data Normal | Chillin'Vibe Admin
@endsection

@section('content')
<h3>Hapus Data Pelanggan Normal</h3>
<div class="form-login">
<h4>Ingin Menghapus Data ?</h4>

  <button type="submit" class="btn btn-simpan" style="width: 40%; margin: 20px auto;" onclick="navigateTo('{{ url('/normal/destroy/' . $normal->id ) }}')">
  <span class="simpan_name">Ya</span>
  </button>

  <button type="submit" class="btn btn-simpan" style="width: 40%; margin: 20px auto;" onclick="navigateTo('/normal')">
  <span class="simpan_name">Batal</span>
  </button>

</div>

<script>
function navigateTo(url) {
    window.location.href = url;
}
</script>

@endsection
