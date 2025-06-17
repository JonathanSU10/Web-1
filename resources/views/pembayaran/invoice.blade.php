<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran</title>
    <style>
        body {
            width: 9cm;
            height: 13cm;
            padding: 0.7cm;
            font-family: Arial, sans-serif;
            font-size: 11px;
            border: 1px solid #000;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 50px;
            height: auto;
            margin-bottom: 5px;
        }

        .header h4 {
            margin: 2px 0;
            font-size: 12px;
        }

        .header p {
            font-size: 10px;
            margin: 0;
        }

        .invoice-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin: 10px 0;
            text-decoration: underline;
        }

        .info p {
            margin: 6px 0;
            line-height: 1.4;
        }

        .info label {
            display: inline-block;
            width: 95px;
            font-weight: bold;
        }

        .footer {
            position: absolute;
            bottom: 0.6cm;
            width: 100%;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('sipenmaru/images/sako_tour_logo.png') }}" alt="Logo">
        <h4>PT SAKO UTAMA WISATA</h4>
        <p>Jl. Kampar Raya No. 4A</p>
        <p>Palembang, Sumatera Selatan</p>
    </div>

    <div class="invoice-title">INVOICE PEMBAYARAN</div>

    <div class="info">
        <p><label>Nama Jamaah</label>: {{ $data->pendaftaran->nama }}</p>
        <p><label>ID Pembayaran</label>: {{ $data->id_pembayaran }}</p>
        <p><label>ID Pendaftaran</label>: {{ $data->pendaftaran->id_pendaftaran }}</p>
        <p><label>Paket Umrah</label>: {{ $data->pendaftaran->pilihan1->nama_paket ?? '-' }}</p>
        <p><label>Biaya</label>: Rp {{ number_format($data->pendaftaran->pilihan1->harga_paket ?? 0, 0, ',', '.') }}</p>
        <p><label>Tanggal Bayar</label>: {{ \Carbon\Carbon::parse($data->tgl_pembayaran)->format('d-m-Y') }}</p>
        <p><label>Status</label>: {{ strtoupper($data->status) }}</p>
    </div>

    <div class="footer">
        <em>Dicetak otomatis oleh sistem — www.sakotour.co.id</em>
    </div>

</body>
</html>
