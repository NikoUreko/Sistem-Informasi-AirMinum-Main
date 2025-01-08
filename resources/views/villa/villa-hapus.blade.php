@extends('layouts.app')

@section('title')
Hapus Data Villa | Chillin'Vibe Admin
@endsection

@section('content')
<h3>Hapus Data Villa</h3>
<div class="form-login">
<h4>Ingin Menghapus Data ?</h4>

  <button type="button" class="btn btn-simpan" style="width: 40%; margin: 20px auto;" onclick="navigateTo('{{ url('/villa/destroy/' . $villa->id) }}')">
  <span class="simpan_name">Ya</span>
  </button>

  <button type="button" class="btn btn-simpan" style="width: 40%; margin: 20px auto;" onclick="navigateTo('/villa')">
    <span class="simpan_name">Batal</span>
  </button>

</div>

<script>
function navigateTo(url) {
    window.location.href = url;
}
</script>

@endsection
