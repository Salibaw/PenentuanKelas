<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Penempatan Kelas - SMP 2 Sumenep</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .gradient-nav {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        .logo-img {
            height: 40px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .header-section {
            background: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%234361ee" fill-opacity="0.1" d="M0,128L48,117.3C96,107,192,85,288,96C384,107,480,149,576,165.3C672,181,768,171,864,149.3C960,128,1056,96,1152,96C1248,96,1344,128,1392,144L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-position: bottom;
            background-repeat: no-repeat;
            background-size: contain;
            padding: 3rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .search-container {
            margin-top: -2.5rem;
            position: relative;
            z-index: 100;
        }
        
        .search-box {
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.15);
            border-radius: 50px;
            overflow: hidden;
            background: white;
            padding: 0.25rem;
        }
        
        .search-box input {
            border: none;
            outline: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            flex: 1;
        }
        
        .btn-primary-gradient {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
        }
        
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            --bs-table-bg: transparent;
            margin-bottom: 0;
        }
        
        .table thead {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            padding: 1rem 1.5rem;
            border-bottom: 2px solid #dee2e6;
        }
        
        .table td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
            transform: translateX(2px);
        }
        
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            color: var(--primary-color);
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .class-badge {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: linear-gradient(to right, #d4edda, #c3e6cb);
            color: #155724;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            border: 2px solid #c3e6cb;
            min-width: 80px;
        }
        
        .wali-info {
            line-height: 1.4;
        }
        
        .wali-nama {
            font-weight: 600;
            color: var(--dark-text);
        }
        
        .wali-nip {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .no-data {
            padding: 4rem 2rem;
            text-align: center;
        }
        
        .no-data-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }
        
        .pagination-custom .page-link {
            border: none;
            color: var(--primary-color);
            border-radius: 10px;
            margin: 0 3px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .pagination-custom .page-item.active .page-link {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        }
        
        .pagination-custom .page-link:hover:not(.active) {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }
        
        .result-info {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.04);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }
        
        .footer {
            margin-top: auto;
            background: white;
            padding: 2rem 0;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-section {
                padding: 2rem 0;
            }
            
            .search-container {
                margin-top: -1.5rem;
            }
            
            .search-box {
                border-radius: 12px;
            }
            
            .btn-primary-gradient {
                padding: 0.75rem 1.5rem;
            }
            
            .table th,
            .table td {
                padding: 1rem;
                font-size: 0.9rem;
            }
            
            .class-badge {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }
            
            .pagination-custom .page-link {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .search-box input {
                padding: 0.75rem 1rem;
            }
            
            .table th,
            .table td {
                padding: 0.75rem;
            }
            
            .rank-badge {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }
            
            .pagination-custom {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg gradient-nav navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="/">
                <img src="assets/img/logo2.png" alt="Logo SMP 2 Sumenep" class="logo-img me-2">
                SMP 2 Sumenep
            </a>
            <a href="/" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Header -->
    <div class="header-section">
        <div class="container text-center">
            <h1 class="fw-bold mb-3" style="color: var(--primary-color);">Cek Penempatan Kelas</h1>
            <p class="lead text-muted mb-0">Silakan cari nama Anda untuk mengetahui pembagian kelas tahun ajaran ini</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container flex-grow-1 fade-in">
        <!-- Search Box -->
        <div class="search-container">
            <form action="{{ route('cek.kelas') }}" method="GET" class="search-box d-flex">
                <input type="text" 
                       name="q" 
                       value="{{ request('q') }}" 
                       placeholder="Ketik nama lengkap siswa..." 
                       class="form-control border-0"
                       autocomplete="off"
                       aria-label="Cari nama siswa">
                <button type="submit" class="btn btn-primary-gradient ms-2">
                    <i class="bi bi-search me-2"></i>Cari
                </button>
            </form>
        </div>

        <!-- Result Info -->
        @if($hasil->total() > 0)
        <div class="result-info fade-in">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="mb-0 fw-semibold">
                        <i class="bi bi-info-circle me-2"></i>
                        Menampilkan {{ $hasil->firstItem() }} - {{ $hasil->lastItem() }} dari {{ $hasil->total() }} siswa
                    </h6>
                </div>
                <div class="col-md-6 text-md-end">
                    @if(request('q'))
                    <span class="text-muted">
                        Hasil pencarian untuk: <strong>"{{ request('q') }}"</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Table -->
        <div class="table-container fade-in">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 80px;" class="text-center">No</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col" class="text-center">Kelas</th>
                            <th scope="col">Wali Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasil as $h)
                        <tr>
                            <td class="text-center">
                                <div class="rank-badge">
                                    {{ ($hasil->currentPage() - 1) * $hasil->perPage() + $loop->iteration }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $h->alternatif->nama_lengkap }}</div>
                            </td>
                            <td class="text-center">
                                <span class="class-badge">{{ $h->kelas }}</span>
                            </td>
                            <td class="wali-info">
                                <div class="wali-nama">{{ $h->walikelas->nama_guru ?? 'Belum Ditentukan' }}</div>
                                <div class="wali-nip">NIP. {{ $h->walikelas->nip ?? '-' }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="no-data">
                                    <i class="bi bi-search no-data-icon"></i>
                                    <h5 class="fw-semibold mb-2">
                                        @if(request('q'))
                                            Nama "{{ request('q') }}" tidak ditemukan
                                        @else
                                            Data penempatan kelas belum tersedia
                                        @endif
                                    </h5>
                                    <p class="text-muted mb-0">
                                        @if(request('q'))
                                            Coba periksa kembali ejaan nama atau hubungi admin
                                        @else
                                            Silakan hubungi administrator untuk informasi lebih lanjut
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($hasil->hasPages())
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Navigasi halaman hasil">
                {{ $hasil->onEachSide(1)->links('pagination.bootstrap-5', ['class' => 'pagination-custom']) }}
            </nav>
        </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="text-center">
                <p class="mb-2">
                    &copy; {{ date('Y') }} SMP 2 Sumenep. Sistem Pendukung Keputusan Pembagian Kelas.
                </p>
                <p class="text-muted small mb-0">
                    <i class="bi bi-shield-check me-1"></i>
                    Data diperbarui secara berkala
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add animation to table rows
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
                row.classList.add('fade-in');
            });
            
            // Focus on search input
            const searchInput = document.querySelector('input[name="q"]');
            if (searchInput) {
                searchInput.focus();
            }
            
            // Add smooth scroll for pagination
            document.querySelectorAll('.pagination-custom .page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.getAttribute('href').includes('#')) {
                        e.preventDefault();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        setTimeout(() => {
                            window.location.href = this.getAttribute('href');
                        }, 500);
                    }
                });
            });
        });
    </script>
</body>
</html>