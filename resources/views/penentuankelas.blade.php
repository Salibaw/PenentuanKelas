<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Penempatan Kelas - SMP 2 Sumenep</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fe;
            color: #333;
        }

        /* Navbar Sederhana */
        nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .nav-container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }
        .logo { font-weight: bold; font-size: 1.2rem; text-decoration: none; color: white; display: flex; align-items: center; gap: 10px; }
        .logo img { height: 35px; }

        /* Content Header */
        .header-section {
            background: white;
            padding: 40px 20px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        .header-section h1 { color: #4a5568; margin-bottom: 10px; }

        /* Search Box */
        .search-container {
            max-width: 600px;
            margin: -30px auto 40px;
            position: relative;
            z-index: 10;
        }
        .search-box {
            display: flex;
            background: white;
            padding: 10px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .search-box input {
            flex: 1;
            padding: 12px 25px;
            border: none;
            outline: none;
            font-size: 1rem;
            border-radius: 50px;
        }
        .btn-search {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-search:hover { background: #764ba2; }

        /* Table Area */
        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px 80px; }
        .table-wrapper {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8fafc; }
        th { padding: 20px; text-align: left; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 20px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        .rank-badge {
            display: inline-block;
            width: 30px; height: 30px;
            line-height: 30px;
            text-align: center;
            background: #ebf4ff;
            color: #667eea;
            border-radius: 50%;
            font-weight: bold;
            font-size: 0.8rem;
        }
        .class-badge {
            background: #f0fdf4;
            color: #16a34a;
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 0.85rem;
            border: 1px solid #dcfce7;
        }
        .wali-info { font-size: 0.9rem; color: #475569; }

        footer { text-align: center; padding: 40px; color: #94a3b8; font-size: 0.9rem; }
    </style>
</head>
<body>

    <nav>
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="assets/img/logo2.png" alt="Logo">
                SMP 2 Sumenep
            </a>
            <a href="/" style="color: white; text-decoration: none; font-size: 0.9rem;"> Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="header-section">
        <h1>Cek Penempatan Kelas</h1>
        <p>Silakan cari nama Anda untuk mengetahui pembagian kelas tahun ajaran ini.</p>
    </div>

    <div class="container">
        <div class="search-container">
            <form action="{{ route('cek.kelas') }}" method="GET" class="search-box">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik Nama Lengkap Anda...">
                <button type="submit" class="btn-search">Cari</button>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px; text-align: center;">No</th>
                        <th>Nama Lengkap</th>
                        <th style="text-align: center;">Kelas</th>
                        <th>Wali Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasil as $h)
                    <tr>
                        <td style="text-align: center;"><span class="rank-badge">{{ $h->ranking }}</span></td>
                        <td style="font-weight: 600; color: #1e293b;">{{ $h->alternatif->nama_lengkap }}</td>
                        <td style="text-align: center;"><span class="class-badge">{{ $h->kelas }}</span></td>
                        <td class="wali-info">
                            <strong>{{ $h->walikelas->nama_guru ?? 'TBA' }}</strong><br>
                            <small class="text-muted">NIP. {{ $h->walikelas->nip ?? '-' }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 100px; text-align: center; color: #94a3b8;">
                            @if(request('q'))
                                Nama "<strong>{{ request('q') }}</strong>" tidak ditemukan. <br>
                                <small>Pastikan pengetikan nama sudah benar.</small>
                            @else
                                Data penempatan kelas belum dipublikasikan oleh sistem.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <footer>
            &copy; 2025 SMP 2 Sumenep. Sistem Pendukung Keputusan Pembagian Kelas.
        </footer>
    </div>

</body>
</html>