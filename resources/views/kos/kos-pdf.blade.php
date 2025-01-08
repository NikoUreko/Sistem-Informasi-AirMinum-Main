<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .garis {
            border: 0;
            height: 5px;
            background: black;
            margin: 20px 0;
        }

        .receipt {
            width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: 'Courier New', Courier, monospace;
            word-wrap: break-word;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .content p {
            margin: 0;
            margin-bottom: 5px;
            white-space: pre;
        }

        .peringatan {
            text-align: justify;
            margin-bottom: 20px;
            word-wrap: break-word;
        }

        .peringatan li {
            margin-bottom: 5px;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <p>Himpunan Penduduk Pemakaian Air Minum (HIPPAM)</p>
            <h1>"TIRTO LESTARI"</h1>
            <div class="garis"></div>
        </div>

        <div class="content">
            <p>Nama                : {{ $kos->nama }}</p>
            <p>Alamat              : {{ $kos->alamat }}</p>
            <p>bln/thn             : {{ $kos->bln_thn }}</p>
            <p>Golongan            : .....................</p>
            <p>No. meter bulan ini : {{ $kos->no_meterblnini }}</p>
            <p>No. meter bulan lalu: {{ $kos->no_meterblnlalu }} </p>
            <p>Pemakaian (m)       : {{ $kos->pemakaian_M }}</p>
            <p>===============================================</p>
            <p>Tarif I   (Rp.  500/0-20m)   : Rp {{ number_format($kos->tarif_I, 0, ',', '.') }}</p>
            <p>Tarif II  (Rp.  1000/21-40m) : Rp {{ number_format($kos->tarif_II, 0, ',', '.') }}</p>
            <p>Tarif III (Rp.  1500/41-..m) : Rp {{ number_format($kos->tarif_III, 0, ',', '.') }}</p>
            <p>Total Harga Air    : Rp {{ number_format($kos->harga_air, 0, ',', '.') }}</p>
            <p>Sewa meter         : Rp {{ number_format($kos->sewa_M, 0, ',', '.') }}</p>
            <p>Denda              : Rp {{ $kos->denda === 'iya2' ? '10,000' : ($kos->denda === 'iya' ? '5,000' : '0') }}</p>
            <p>===============================================</p>
            <p>Total pembayaran   : Rp {{ number_format($kos->total_byr, 0, ',', '.') }}</p>
            <p>Tanggal pembayaran : {{ $kos->created_at}}</p>
        </div>

        <div class="peringatan">
            <p>Peringatan :</p>
            <ol type="A">
                <li>Pembayaran tgl 1-10, jam (15-17) 3-5 sore di ....</li>
                <li>Pembayaran tgl 11-30 dikenakan denda Rp 5000,-.</li>
                <li>2 Bulan berturut-turut tidak membayar tanpa keterangan saluran ditutup sementara.</li>
                <li>Saluran dibuka kembali setelah rekening dibayar lunas ditambah denda Rp 10.000,-.</li>
                <li>Merusak meteran, mengambil air di luar meter atau meteran hilang maka saluran ditutup.</li>
                <li>Tidak boleh disalurkan ke tempat lain</li>
            </ol>
        </div>
    </div>
</body>
</html>
