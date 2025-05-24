<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
                                        <td>{{ $x->pendaftaran->nama }}</a></td>
                                        <td>{{ $x->pendaftaran->pilihan1->nama_paket }}</td>
                                        <td>{{ $x->pendaftaran->pilihan1->harga_paket }}</td>
                                        <td>{{ $x->tgl_pembayaran }}</td>
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
