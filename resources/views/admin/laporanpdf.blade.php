<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Laporan Penjualan</title>
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 12px;
            }
            h2 {
                text-align: center;
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            th,
            td {
                border: 1px solid #777;
                padding: 6px;
                text-align: left;
            }
            th {
                background-color: #e9ecef;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                font-size: 11px;
                color: #555;
            }
        </style>
    </head>
    <body>
        <center>
        <img src="{{ public_path('images/logo.png') }}" style="width:120px; margin:0 auto; display:block;">
        </center>
        <h2>Laporan Penjualan </h2>
        <h2>Dicetak Tanggal {{ \Carbon\Carbon::now('Asia/Makassar')->translatedFormat('d F Y') }}</h2>

        <table>
            <thead>
                <tr>
                    <th>ID Laporan</th>
                    <th>Tanggal</th>
                    <th>Periode</th>
                    <th>Total Produk</th>
                    <th>Total Pesanan</th>
                    <th>Total Pendapatan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporans as $lap)
                <tr>
                    <td>LAP#{{ $lap->laporan_id }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($lap->laporan_tanggal)->translatedFormat('d F Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($lap->laporan_periode_mulai)->translatedFormat('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($lap->laporan_periode_selesai)->translatedFormat('d F Y') }}
                    </td>
                    <td>{{ $lap->laporan_total_produk }}</td>
                    <td>{{ $lap->laporan_total_pesanan }}</td>
                    <td>
                        Rp
                        {{ number_format($lap->laporan_total_pendapatan, 0, ',', '.') }}
                    </td>
                    <td>{{ $lap->laporan_keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Dicetak pada
            {{ now()->setTimezone('Asia/Makassar')->translatedFormat('d F Y H:i') }}
            WITA
        </div>
    </body>
</html>
