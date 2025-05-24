<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Pendaftaran</title>
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
    <h2>Data Pendaftaran</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>KTP</th>
                <th>Nama</th>
                <th>Paket</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($viewData as $x)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $x->nik }}</td>
                    <td>{{ $x->nama }}</td>
                    <td>{{ $x->pilihan1->nama_paket ?? '-' }}</td>
                    <td>{{ $x->jenis_kelamin }}</td>
                    <td>{{ $x->tgl_pendaftaran }}</td>
                    <td>{{ $x->status_pendaftaran }}</td>
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
