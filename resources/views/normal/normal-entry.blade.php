@extends('layouts.app')

@section('title')
Tambah Normal | Chillin'Vibe Admin
@endsection

@section('content')
<h3>Input Data Pelanggan Normal</h3>
<div class="form-login">
  <form action="{{ url('/normal/store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <label for="nama">Nama</label>
    <input class="input" type="text" name="nama" id="nama" placeholder="nama" value="{{ old('nama') }}" />
    @error('nama')
    <p style="font-size: 10px; color: red">{{ $message }}</p>
    @enderror

    <label for="alamat">Alamat</label>
    <input class="input" type="text" name="alamat" id="alamat" placeholder="alamat" value="{{ old('alamat') }}" />
    @error('alamat')
    <p style="font-size: 10px; color: red">{{ $message }}</p>
    @enderror

    <label for="bln_thn">Bulan/Tahun</label>
    <input class="input" type="month" name="bln_thn" id="bln_thn" value="{{ old('bln_thn') }}" />
    @error('bln_thn')
    <p style="font-size: 10px; color: red">{{ $message }}</p>
    @enderror

    <label for="no_meterblnini">No Meter Bulan ini</label>
    <input class="input" type="text" name="no_meterblnini" id="no_meterblnini" placeholder="no meter bulan ini" value="{{ old('no_meterblnini') }}" />
    @error('no_meterblnini')
    <p style="font-size: 10px; color: red">{{ $message }}</p>
    @enderror

    <label for="no_meterblnlalu">No Meter Bulan lalu</label>
    <input class="input" type="text" name="no_meterblnlalu" id="no_meterblnlalu" placeholder="no meter bulan lalu" value="{{ old('no_meterblnlalu') }}" />
    @error('no_meterblnlalu')
    <p style="font-size: 10px; color: red">{{ $message }}</p>
    @enderror    

    <label for="pemakaian_M">Pemakaian M</label>
    <input class="input-readonly" type="text" name="pemakaian_M" id="pemakaian_M" placeholder="pemakaian m" value="{{ old('pemakaian_M') }}" readonly />
    @error('pemakaian_M')
    <p style="font-size: 10px; color: red">{{ $message }}</p>
    @enderror

    <label for="pemakaian_level_1">Pemakaian (0-15m³)</label>
    <input class="input-readonly" type="number" name="pemakaian_level_1" id="pemakaian_level_1" placeholder="0-15m³" value="{{ old('pemakaian_level_1') }}" readonly />
    <p class="tarif-label">Tarif I: Rp <span id="tarif_1_display" class="tarif-value">0</span></p>

    <label for="pemakaian_level_2">Pemakaian (16-30m³)</label>
    <input class="input-readonly" type="number" name="pemakaian_level_2" id="pemakaian_level_2" placeholder="16-30m³" value="{{ old('pemakaian_level_2') }}" readonly />
    <p class="tarif-label">Tarif II: Rp <span id="tarif_2_display" class="tarif-value">0</span></p>

    <label for="pemakaian_level_3">Pemakaian (31-45m³)</label>
    <input class="input-readonly" type="number" name="pemakaian_level_3" id="pemakaian_level_3" placeholder="31-45m³" value="{{ old('pemakaian_level_3') }}" readonly />
    <p class="tarif-label">Tarif III: Rp <span id="tarif_3_display" class="tarif-value">0</span></p>

    <label for="pemakaian_level_4">Pemakaian (>46m³)</label>
    <input class="input-readonly" type="number" name="pemakaian_level_4" id="pemakaian_level_4" placeholder=">46m³" value="{{ old('pemakaian_level_4') }}" readonly />
    <p class="tarif-label">Tarif IV: Rp <span id="tarif_4_display" class="tarif-value">0</span></p>

    <p class="total-label">Total Harga Air: Rp <span id="harga_air_display" class="total-value">0</span></p>

    <label for="sewa_M">Sewa Meter</label>
    <input class="input-readonly" type="number" name="sewa_M" id="sewa_M" placeholder="Sewa Meter" value="2500" readonly />
  

    <label for="denda">Denda</label>
    <select name="denda" id="denda" onchange="calculateTarif()">
      <option value="tidak">Tidak</option>
      <option value="iya">Denda</option>
      <option value="iya2">Denda 2</option>
    </select>

    <p class="total-label-2">Total Pembayaran : Rp <span id="total_bayar_display" class="total-value">0</span></p>

    <button type="submit" class="btn btn-simpan" style="margin-top: 50px">
      <span class="simpan_name">Simpan Data</span>
    </button>
  </form>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const noMeterBlnIniInput = document.getElementById("no_meterblnini");
      const noMeterBlnLaluInput = document.getElementById("no_meterblnlalu");
      const pemakaianMInput = document.getElementById("pemakaian_M");
      const pemakaianLevel1Input = document.getElementById("pemakaian_level_1");
      const pemakaianLevel2Input = document.getElementById("pemakaian_level_2");
      const pemakaianLevel3Input = document.getElementById("pemakaian_level_3");
      const pemakaianLevel4Input = document.getElementById("pemakaian_level_4");

      function calculatePemakaian() {
        const noMeterBlnIni = parseInt(noMeterBlnIniInput.value) || 0;
        const noMeterBlnLalu = parseInt(noMeterBlnLaluInput.value) || 0;
        const pemakaianM = noMeterBlnIni - noMeterBlnLalu;
        pemakaianMInput.value = pemakaianM > 0 ? pemakaianM : 0;

        let sisaPemakaian = pemakaianM;
        pemakaianLevel1Input.value = Math.min(sisaPemakaian, 15);
        sisaPemakaian = Math.max(0, sisaPemakaian - 15);

        pemakaianLevel2Input.value = Math.min(sisaPemakaian, 15);
        sisaPemakaian = Math.max(0, sisaPemakaian - 15);

        pemakaianLevel3Input.value = Math.min(sisaPemakaian, 15);
        sisaPemakaian = Math.max(0, sisaPemakaian - 15);

        pemakaianLevel4Input.value = Math.max(0, sisaPemakaian);
        
        calculateTarif()
        
      }

      noMeterBlnIniInput.addEventListener("input", calculatePemakaian);
      noMeterBlnLaluInput.addEventListener("input", calculatePemakaian);

      calculateTarif()
      
    });

function calculateTarif() {


    
    
const tarif1 = 250;  
const tarif2 = 500;  
const tarif3 = 750;  
const tarif4 = 1000;


const pemakaianLevel1 = parseInt(document.getElementById("pemakaian_level_1").value) || 0;
const pemakaianLevel2 = parseInt(document.getElementById("pemakaian_level_2").value) || 0;
const pemakaianLevel3 = parseInt(document.getElementById("pemakaian_level_3").value) || 0;
const pemakaianLevel4 = parseInt(document.getElementById("pemakaian_level_4").value) || 0;



const tarifLevel1 = pemakaianLevel1 * tarif1;
const tarifLevel2 = pemakaianLevel2 * tarif2;
const tarifLevel3 = pemakaianLevel3 * tarif3;
const tarifLevel4 = pemakaianLevel4 * tarif4;


const totalHargaAir = tarifLevel1 + tarifLevel2 + tarifLevel3 + tarifLevel4;


const sewaMeter = 2500;



const dendaValue = document.getElementById("denda").value;

let dendaAmount;

if (dendaValue === "iya") {
  dendaAmount = 5000;
} else if (dendaValue === "iya2") {
  dendaAmount = 10000;
} else {
  dendaAmount = 0;
}


const totalBayar = totalHargaAir + dendaAmount + sewaMeter;


document.getElementById("tarif_1_display").textContent = tarifLevel1.toLocaleString();
document.getElementById("tarif_2_display").textContent = tarifLevel2.toLocaleString();
document.getElementById("tarif_3_display").textContent = tarifLevel3.toLocaleString();
document.getElementById("tarif_4_display").textContent = tarifLevel4.toLocaleString();
document.getElementById("harga_air_display").textContent = totalHargaAir.toLocaleString();
document.getElementById("total_bayar_display").textContent = totalBayar.toLocaleString();
}

  </script>
</div>
@endsection
