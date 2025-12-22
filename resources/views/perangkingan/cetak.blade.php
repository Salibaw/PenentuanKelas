<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Daftar Kelas {{ $kelas }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .info-table { width: 100%; margin-bottom: 20px; font-weight: bold; }
        table.main-table { width: 100%; border-collapse: collapse; }
        table.main-table th, table.main-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        table.main-table th { background-color: #f2f2f2; text-align: center; }
        .footer { margin-top: 40px; float: right; width: 250px; text-align: center; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Cetak Sekarang</button>
        <button onclick="window.history.back()">Kembali</button>
    </div>

    <div class="header">
        <img src="{{ asset('assets/img/logo2.png') }}" style="height: 60px; float: left;">
        <h2>Pemerintah Kabupaten Sumenep</h2>
        <h3>Dinas Pendidikan - SMPN 2 Sumenep</h3>
        <p>Jl. Trunojoyo No. 123, Sumenep, Jawa Timur</p>
    </div>

    <h3 style="text-align: center;">DAFTAR PENEMPATAN KELAS SISWA BARU</h3>

    <table class="info-table">
        <tr>
            <td width="100">KELAS</td><td>: {{ $kelas ?? 'Semua Kelas' }}</td>
            <td width="120" style="text-align: right;">TAHUN AJARAN</td><td>: 2025/2026</td>
        </tr>
        <tr>
            <td>WALI KELAS</td><td>: {{ $data->first()->walikelas->nama_guru ?? '-' }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="40">NO</th>
                <th>NAMA LENGKAP</th>
                <th width="100">KELAS</th>
                <th width="120">RANKING</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $row->alternatif->nama_lengkap }}</td>
                <td style="text-align: center;">{{ $row->kelas }}</td>
                <td style="text-align: center;">{{ $row->ranking }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sumenep, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah,</p>
        <br><br><br>
        <strong>( ...................................... )</strong><br>
        NIP. .........................
    </div>
</body>
</html>