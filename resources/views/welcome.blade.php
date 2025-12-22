<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMP 2 Sumenep - Penentuan Kelas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .logo img {
            height: 40px;
            width: auto;
            display: block;
        }

        /* Navbar */
        nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background-image: url('assets/img/bebas.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            padding: 200px 20px;
            text-align: center;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            background: rgba(0, 0, 0, 0.35);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(4px);
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #fff;
            text-shadow: 0 3px 10px rgba(0, 0, 0, 0.8);
            animation: fadeInUp 1s;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s;
            animation: fadeInUp 1s 0.4s backwards;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }

        /* Footer */
        footer {
            background: #2d3748;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="nav-container">
            <div class="logo">
                <img src="assets/img/logo2.png" alt="Logo SMP 2 Sumenep">
                SMP 2 Sumenep
            </div>
            <ul class="nav-menu">
                <li><a href="/">Beranda</a></li>
                <li><a href="{{ route('cek.kelas') }}">Penentuan Kelas</a></li>
                <li><a href="{{ 'login' }}">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di SMP 2 Sumenep</h1>
            <a href="{{ route('cek.kelas') }}" class="btn">Cek Kelas Anda</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 SMP 2 Sumenep. All Rights Reserved.</p>
        <p>Jl. Trunojoyo No. 123, Sumenep, Jawa Timur</p>
    </footer>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.style.background = 'linear-gradient(135deg, #5568d3 0%, #6941a0 100%)';
            } else {
                nav.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            }
        });
    </script>
</body>

</html>