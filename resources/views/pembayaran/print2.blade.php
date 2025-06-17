<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .header .title {
            flex: 1;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {
            @page {
                margin: 20mm;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('sipenmaru/images/sako_tour_logo.png') }}" alt="Logo Sako Tour">
        <div class="title">
            <h2>PT SAKO UTAMA WISATA</h2>
        </div>
    </div>

    <hr>

    <h2>Data Pembayaran</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pendaftar</th>
                <th>Paket</th>
                <th>Biaya Pendaftaran</th>
                <th>Tanggal Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($viewData as $x)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $x->pendaftaran->nama }}</td>
                    <td>{{ $x->pendaftaran->pilihan1->nama_paket ?? '-' }}</td>
                    <td>{{ number_format($x->pendaftaran->pilihan1->harga_paket ?? 0, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($x->tgl_pembayaran)->format('d/m/Y') }}</td>
                    <td>{{ $x->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>

</body>
</html>
