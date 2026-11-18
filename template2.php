<?php
/**
 * =================================================================
 * TEMPLATE 2 - PLATINUM MIDNIGHT (BLACK & GOLD LUXURY EDITION)
 * =================================================================
 */
include 'koneksi.php';

// Ambil slug atau cek mode demo dari URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($koneksi, $_GET['slug']) : '';
$is_demo = isset($_GET['demo']) ? true : false;

if ($is_demo) {
    // Data dummy / contoh tampilan mewah untuk mode Demo Landing Page
    $data = [
        'id_portfolio'    => 0,
        'nama_usaha'      => 'Lumière Haute Couture',
        'tagline'         => 'The Pinnacle of Elite Beauty & Salon Experience',
        'bio'             => 'Selamat datang di studio perawatan eksklusif kami. Kami menghadirkan mahakarya dan pelayanan kelas dunia untuk memancarkan pesona serta keanggunan sejati Anda.',
        'alamat'          => 'Boulevard St. Honoré, Elite District',
        'produk_unggulan' => 'Royal Gold Facial & Diamond Hair Spa',
        'no_wa'           => '6281234567890',
        'logo'            => 'default.png',
        'foto_produk'     => '',
        'template'        => 'template2',
        'status'          => 'Aktif'
    ];
    $query_galeri = false; 
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE slug = '$slug'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Website portofolio tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }

    $id_portfolio = $data['id_portfolio'];
    $query_galeri = mysqli_query($koneksi, "SELECT * FROM portfolio_images WHERE portfolio_id = '$id_portfolio'");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama_usaha']); ?> &mdash; Elite Salon & Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-obsidian: #060608;
            --bg-card: #0d0d12;
            --gold-primary: #d4af37;
            --gold-light: #f3e5ab;
            --gold-dark: #aa771c;
            --text-bright: #ffffff;
            --text-soft: #94a3b8;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #12100e 0%, var(--bg-obsidian) 70%);
            color: var(--text-bright);
            min-height: 100vh;
            overflow-x: hidden;
        }
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }

        /* Navbar Mewah */
        .navbar-luxury {
            background: rgba(6, 6, 8, 0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.25);
            padding: 16px 0;
        }
        .brand-logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, #f3e5ab 0%, #d4af37 50%, #aa771c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
            text-decoration: none;
        }

        /* Tombol Emas Elegan */
        .btn-gold-solid {
            background: linear-gradient(135deg, #d4af37 0%, #aa771c 100%);
            color: #060608 !important;
            font-weight: 700;
            border-radius: 50px;
            padding: 12px 28px;
            border: none;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
            transition: 0.3s;
        }
        .btn-gold-solid:hover {
            background: linear-gradient(135deg, #e5c158 0%, #c48b22 100%);
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(212, 175, 55, 0.45);
        }
        .btn-gold-outline {
            background: transparent;
            border: 1.5px solid rgba(212, 175, 55, 0.4);
            color: var(--gold-light) !important;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 28px;
            transition: 0.3s;
        }
        .btn-gold-outline:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--gold-primary);
            color: #fff !important;
        }

        /* Hero & Content Layout */
        .hero-section {
            padding: 80px 0;
        }
        .badge-editorial {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--gold-light);
            font-weight: 600;
            font-size: 12px;
            padding: 6px 16px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .business-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.1;
            color: #ffffff;
            margin-bottom: 15px;
        }
        .business-tagline {
            color: var(--text-soft);
            font-size: 1.15rem;
            margin-bottom: 30px;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        /* Card / Kotak Informasi */
        .card-lux {
            background: var(--bg-card);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        /* Frame Foto Utama / Logo */
        .showcase-frame {
            background: var(--bg-card);
            border: 1.5px solid rgba(212, 175, 55, 0.3);
            border-radius: 28px;
            padding: 20px;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7);
            overflow: hidden;
            text-align: center;
        }
        .showcase-frame img {
            width: 100%;
            max-height: 380px;
            object-fit: cover;
            border-radius: 18px;
            transition: transform 0.6s ease;
        }
        .showcase-frame:hover img {
            transform: scale(1.03);
        }

        /* Galeri Tambahan */
        .gallery-card {
            background: var(--bg-card);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: 0.3s;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.5);
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.15);
        }
        .gallery-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        footer {
            background: #040405;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            padding: 40px 0;
            color: var(--text-soft);
            font-size: 13.5px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR LUXURY -->
    <nav class="navbar navbar-expand-lg navbar-luxury sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="btn btn-gold-outline btn-sm px-3 py-2 rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Beranda Utama
            </a>
            
            <a href="#" class="brand-logo-text mb-0">
                <?= htmlspecialchars($data['nama_usaha']); ?>
            </a>

            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['no_wa']); ?>?text=Halo%20<?= urlencode($data['nama_usaha']); ?>,%20saya%20tertarik%20dengan%20layanan%20Anda." target="_blank" class="btn btn-gold-solid btn-sm px-4 py-2">
                <i class="bi bi-whatsapp me-1"></i> WhatsApp Booking
            </a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="hero-section container">
        <div class="row align-items-center g-5">
            <!-- Kolom Teks Kiri -->
            <div class="col-lg-7">
                <span class="badge-editorial font-serif">
                    <i class="bi bi-stars me-1"></i> Platinum High-End Care
                </span>
                <h1 class="business-title font-serif">
                    <?= htmlspecialchars($data['nama_usaha']); ?>
                </h1>
                <p class="business-tagline">
                    <?= htmlspecialchars($data['tagline']); ?>
                </p>

                <!-- Deskripsi Bio -->
                <div class="card-lux mb-4">
                    <h5 class="font-serif text-white fs-4 mb-2" style="color: #f3e5ab;">Tentang Studio & Layanan</h5>
                    <p class="text-secondary mb-0" style="line-height: 1.7; font-size: 15px;">
                        <?= nl2br(htmlspecialchars($data['bio'])); ?>
                    </p>
                </div>

                <!-- Informasi Kontak & Alamat -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card-lux h-100 d-flex flex-column justify-content-center py-3">
                            <span class="text-secondary small d-block mb-1"><i class="bi bi-geo-alt-fill text-warning me-1"></i> Studio Location</span>
                            <strong class="text-white small"><?= !empty($data['alamat']) ? htmlspecialchars($data['alamat']) : 'Lokasi eksklusif segera hadir'; ?></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-lux h-100 d-flex flex-column justify-content-center py-3">
                            <span class="text-secondary small d-block mb-1"><i class="bi bi-gem text-warning me-1"></i> Signature Treatment</span>
                            <strong class="text-white small"><?= htmlspecialchars($data['produk_unggulan']); ?></strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['no_wa']); ?>?text=Halo%20<?= urlencode($data['nama_usaha']); ?>,%20saya%20ingin%20melakukan%20reservasi%20jadwal%20treatment." target="_blank" class="btn btn-gold-solid px-4 py-3 shadow">
                        <i class="bi bi-calendar-check me-2"></i> Schedule Premium Treatment
                    </a>
                </div>
            </div>

            <!-- Kolom Gambar Utama Kanan -->
            <div class="col-lg-5">
                <div class="showcase-frame">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                        <span class="small font-serif text-secondary" style="letter-spacing: 1px;"><i class="bi bi-camera me-1"></i> Studio Showcase</span>
                        <span class="badge" style="background: rgba(212,175,55,0.15); color: #f3e5ab; border: 1px solid rgba(212,175,55,0.3);">Verified Results</span>
                    </div>

                    <?php if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])): ?>
                        <img src="uploads/<?= $data['foto_produk']; ?>" alt="<?= htmlspecialchars($data['nama_usaha']); ?>">
                    <?php elseif (!empty($data['logo']) && file_exists("uploads/" . $data['logo'])): ?>
                        <img src="uploads/<?= $data['logo']; ?>" style="object-fit: contain; background: #060608; padding: 20px;" alt="<?= htmlspecialchars($data['nama_usaha']); ?>">
                    <?php else: ?>
                        <div class="py-5 text-secondary">
                            <i class="bi bi-shop fs-1" style="color: #d4af37;"></i>
                            <p class="small mt-2">Visual Eksklusif</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- SECTION GALERI TAMBAHAN -->
    <?php if ($query_galeri && mysqli_num_rows($query_galeri) > 0): ?>
    <section class="container py-5 border-top border-light border-opacity-10">
        <div class="text-center mb-5">
            <span class="badge-editorial font-serif">Curated Gallery</span>
            <h2 class="font-serif text-white fw-bold display-6">Eksklusif Hasil Studio & Perawatan</h2>
            <p class="text-secondary small">Jelajahi galeri mahakarya dan transformasi terbaik dari studio kami.</p>
        </div>

        <div class="row g-4">
            <?php while ($gal = mysqli_fetch_assoc($query_galeri)): ?>
            <div class="col-md-4">
                <div class="gallery-card">
                    <img src="uploads/<?= htmlspecialchars($gal['foto']); ?>" class="gallery-img" alt="Galeri <?= htmlspecialchars($data['nama_usaha']); ?>">
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <p class="fw-semibold font-serif fs-5 mb-1" style="color: #f3e5ab; letter-spacing: 1px;"><?= htmlspecialchars($data['nama_usaha']); ?></p>
            <p class="text-secondary small mb-2"><?= htmlspecialchars($data['tagline']); ?></p>
            <p class="mb-0 text-secondary" style="font-size: 12.5px;">Powered by Haute Couture Digital &bull; Proyek UKK RPL &copy; 2026</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>