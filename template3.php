
<?php
include 'koneksi.php';

$is_demo = isset($_GET['demo']) && $_GET['demo'] === 'true';

if ($is_demo) {

    $data = [
        'id_portfolio' => 0,
        'nama_usaha' => 'Lumière Blue Studio',
        'tagline' => 'Elegance Beyond Imagination',
        'bio' => 'Selamat datang di Lumière Blue Studio. Kami menghadirkan pengalaman eksklusif dengan pelayanan profesional, kualitas terbaik, dan sentuhan elegan untuk setiap pelanggan. Temukan keindahan dalam setiap detail bersama kami.',
        'alamat' => 'Majalengka, Jawa Barat',
        'produk_unggulan' => 'Premium Beauty & Lifestyle Treatment',
        'no_wa' => '6281234567890',
        'foto_produk' => '',
        'logo' => ''
    ];

    $query_galeri = false;

} else {

    $slug = isset($_GET['slug'])
        ? mysqli_real_escape_string($koneksi, $_GET['slug'])
        : '';

    if ($slug === '') {
        echo "<script>alert('Website portofolio tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM portfolios WHERE slug = '$slug'"
    );

    if (!$query) {
        die("Gagal mengambil data portofolio: " . mysqli_error($koneksi));
    }

    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Website portofolio tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }

    $id_portfolio = $data['id_portfolio'];

    $query_galeri = mysqli_query(
        $koneksi,
        "SELECT * FROM portfolio_images WHERE portfolio_id = '$id_portfolio'"
    );
}

$namaUsaha = $data['nama_usaha'] ?? 'Nama Usaha';
$tagline = $data['tagline'] ?? '';
$bio = $data['bio'] ?? '';
$alamat = $data['alamat'] ?? '';
$produkUnggulan = $data['produk_unggulan'] ?? '';
$noWa = preg_replace('/[^0-9]/', '', $data['no_wa'] ?? '');
$fotoProduk = $data['foto_produk'] ?? '';
$logo = $data['logo'] ?? '';

$fotoProdukPath = !empty($fotoProduk)
    ? 'uploads/' . basename($fotoProduk)
    : '';

$logoPath = !empty($logo)
    ? 'uploads/' . basename($logo)
    : '';

$fotoProdukAda = $fotoProdukPath !== '' && is_file($fotoProdukPath);
$logoAda = $logoPath !== '' && is_file($logoPath);

$pesanWhatsApp = urlencode(
    "Halo " . $namaUsaha . ", saya tertarik dengan layanan Anda."
);

$pesanReservasi = urlencode(
    "Halo " . $namaUsaha . ", saya ingin melakukan reservasi layanan."
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($namaUsaha); ?> &mdash; Luxury Portfolio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>

        :root {
            --bg-midnight: #070d1b;
            --bg-card: #101a2d;
            --blue-primary: #6d9dff;
            --blue-light: #c9dcff;
            --blue-glow: rgba(73, 132, 255, 0.28);
            --silver: #dce6f5;
            --text-bright: #f7f9ff;
            --text-soft: #9eacc3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(ellipse at 85% 8%, rgba(42, 91, 174, 0.25), transparent 34%),
                radial-gradient(ellipse at 8% 48%, rgba(24, 54, 105, 0.18), transparent 38%),
                var(--bg-midnight);
            color: var(--text-bright);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }

        .navbar-luxury {
            background: rgba(7, 13, 27, 0.92);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(132, 171, 235, 0.18);
            padding: 16px 0;
        }

        .brand-logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--silver);
            letter-spacing: 1px;
            text-decoration: none;
            text-shadow: 0 0 22px rgba(109, 157, 255, 0.35);
        }

        .btn-gold-solid {
            background: linear-gradient(135deg, #a9c9ff 0%, #5689e8 55%, #315db2 100%);
            color: #07101f !important;
            font-weight: 700;
            border-radius: 50px;
            padding: 12px 28px;
            border: 1px solid rgba(210, 228, 255, 0.45);
            box-shadow: 0 10px 28px rgba(61, 117, 220, 0.25);
            transition: 0.3s;
        }

        .btn-gold-solid:hover {
            background: linear-gradient(135deg, #d3e4ff 0%, #78a7ff 100%);
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(61, 117, 220, 0.4);
        }

        .btn-gold-outline {
            background: rgba(16, 29, 52, 0.45);
            border: 1px solid rgba(151, 187, 245, 0.42);
            color: var(--blue-light) !important;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 28px;
            transition: 0.3s;
        }

        .btn-gold-outline:hover {
            background: rgba(83, 132, 220, 0.16);
            border-color: var(--blue-primary);
            color: #fff !important;
        }

        .hero-section {
            padding: 80px 0;
        }

        .badge-editorial {
            background: rgba(80, 132, 224, 0.12);
            border: 1px solid rgba(132, 171, 235, 0.32);
            color: var(--blue-light);
            font-weight: 600;
            font-size: 12px;
            padding: 7px 16px;
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
            color: #fff;
            margin-bottom: 15px;
            text-shadow: 0 0 34px rgba(109, 157, 255, 0.18);
        }

        .business-tagline {
            color: var(--text-soft);
            font-size: 1.15rem;
            margin-bottom: 30px;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .card-lux {
            background: linear-gradient(145deg, rgba(20, 33, 56, 0.96), rgba(11, 19, 34, 0.98));
            border: 1px solid rgba(132, 171, 235, 0.2);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.28), 0 0 24px rgba(59, 111, 202, 0.06);
        }

        .showcase-frame {
            background: linear-gradient(145deg, #14213a, #0b1322);
            border: 1px solid rgba(151, 187, 245, 0.32);
            border-radius: 28px;
            padding: 20px;
            position: relative;
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.42), 0 0 35px rgba(65, 119, 215, 0.13);
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

        .demo-placeholder {
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle, rgba(81, 133, 226, .22), transparent 60%),
                linear-gradient(145deg, #101d35, #080e1c);
            border-radius: 18px;
            border: 1px solid rgba(151, 187, 245, .15);
        }

        .demo-placeholder i {
            font-size: 75px;
            color: #a9c9ff;
            text-shadow: 0 0 30px rgba(109, 157, 255, .5);
        }

        .gallery-card {
            background: var(--bg-card);
            border: 1px solid rgba(132, 171, 235, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: 0.3s;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            border-color: rgba(132, 171, 235, 0.55);
            box-shadow: 0 15px 35px rgba(53, 105, 196, 0.18);
        }

        .gallery-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        footer {
            background: #050a14;
            border-top: 1px solid rgba(132, 171, 235, 0.2);
            padding: 40px 0;
            color: var(--text-soft);
            font-size: 13.5px;
        }

        @media (max-width: 768px) {

            .hero-section {
                padding: 52px 0;
            }

            .business-title {
                font-size: 2.8rem;
            }

            .brand-logo-text {
                font-size: 20px;
                text-align: center;
            }

            .card-lux {
                padding: 22px;
            }

        }

    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-luxury sticky-top">

        <div class="container d-flex justify-content-between align-items-center">

            <a href="index.php" class="btn btn-gold-outline btn-sm px-3 py-2 rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Beranda Utama
            </a>

            <a href="#" class="brand-logo-text mb-0">
                <?= htmlspecialchars($namaUsaha); ?>
            </a>

            <a href="https://wa.me/<?= htmlspecialchars($noWa); ?>?text=<?= $pesanWhatsApp; ?>"
               target="_blank"
               class="btn btn-gold-solid btn-sm px-4 py-2">

                <i class="bi bi-whatsapp me-1"></i> WhatsApp

            </a>

        </div>

    </nav>

    <header class="hero-section container">

        <div class="row align-items-center g-5">

            <div class="col-lg-7">

                <span class="badge-editorial font-serif">
                    <i class="bi bi-gem me-1"></i> Haute Couture & Lifestyle
                </span>

                <h1 class="business-title font-serif">
                    <?= htmlspecialchars($namaUsaha); ?>
                </h1>

                <p class="business-tagline">
                    <?= htmlspecialchars($tagline); ?>
                </p>

                <div class="card-lux mb-4">

                    <h5 class="font-serif text-white fs-4 mb-2" style="color: #c9dcff !important;">
                        Tentang Kami
                    </h5>

                    <p class="text-secondary mb-0" style="line-height: 1.7; font-size: 15px;">
                        <?= nl2br(htmlspecialchars($bio)); ?>
                    </p>

                </div>

                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <div class="card-lux h-100 d-flex flex-column justify-content-center py-3">

                            <span class="text-secondary small d-block mb-1">
                                <i class="bi bi-geo-alt-fill text-info me-1"></i>
                                Lokasi Butik / Salon
                            </span>

                            <strong class="text-white small">
                                <?= !empty($alamat) ? htmlspecialchars($alamat) : 'Alamat eksklusif segera hadir'; ?>
                            </strong>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card-lux h-100 d-flex flex-column justify-content-center py-3">

                            <span class="text-secondary small d-block mb-1">
                                <i class="bi bi-stars text-info me-1"></i>
                                Layanan Unggulan
                            </span>

                            <strong class="text-white small">
                                <?= htmlspecialchars($produkUnggulan); ?>
                            </strong>

                        </div>

                    </div>

                </div>

                <div class="d-flex flex-wrap gap-3">

                    <a href="https://wa.me/<?= htmlspecialchars($noWa); ?>?text=<?= $pesanReservasi; ?>"
                       target="_blank"
                       class="btn btn-gold-solid px-4 py-3 shadow">

                        <i class="bi bi-calendar-check me-2"></i>
                        Book VIP Consultation

                    </a>

                </div>

            </div>

            <div class="col-lg-5">

                <div class="showcase-frame">

                    <div class="d-flex align-items-center justify-content-between mb-3 px-2">

                        <span class="small font-serif text-secondary" style="letter-spacing: 1px;">
                            <i class="bi bi-camera me-1"></i> Featured Showcase
                        </span>

                        <span class="badge" style="background: rgba(80,132,224,0.15); color: #c9dcff; border: 1px solid rgba(132,171,235,0.3);">
                            Verified Masterpiece
                        </span>

                    </div>

                    <?php if ($fotoProdukAda): ?>

                        <img
                            src="<?= htmlspecialchars($fotoProdukPath); ?>"
                            alt="<?= htmlspecialchars($namaUsaha); ?>"
                        >

                    <?php elseif ($logoAda): ?>

                        <img
                            src="<?= htmlspecialchars($logoPath); ?>"
                            style="object-fit: contain; background: #070d1b; padding: 20px;"
                            alt="<?= htmlspecialchars($namaUsaha); ?>"
                        >

                    <?php else: ?>

                        <div class="demo-placeholder">

                            <i class="bi bi-gem"></i>

                            <p class="small mt-3 mb-0" style="color: #c9dcff; letter-spacing: 2px;">
                                PRIVATE SHOWCASE
                            </p>

                            <span class="small text-secondary mt-2">
                                Exclusive Visual Collection
                            </span>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </header>

    <?php if ($query_galeri && mysqli_num_rows($query_galeri) > 0): ?>

        <section class="container py-5 border-top border-light border-opacity-10">

            <div class="text-center mb-5">

                <span class="badge-editorial font-serif">
                    Curated Gallery
                </span>

                <h2 class="font-serif text-white fw-bold display-6">
                    Eksklusif Koleksi & Perawatan
                </h2>

                <p class="text-secondary small">
                    Jelajahi portofolio mahakarya pilihan dari salon dan butik kami.
                </p>

            </div>

            <div class="row g-4">

                <?php while ($gal = mysqli_fetch_assoc($query_galeri)): ?>

                    <div class="col-md-4">

                        <div class="gallery-card">

                            <img
                                src="uploads/<?= htmlspecialchars($gal['foto']); ?>"
                                class="gallery-img"
                                alt="Galeri <?= htmlspecialchars($namaUsaha); ?>"
                            >

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        </section>

    <?php endif; ?>

    <footer>

        <div class="container text-center">

            <p class="fw-semibold font-serif fs-5 mb-1" style="color: #c9dcff; letter-spacing: 1px;">
                <?= htmlspecialchars($namaUsaha); ?>
            </p>

            <p class="text-secondary small mb-2">
                <?= htmlspecialchars($tagline); ?>
            </p>

            <p class="mb-0 text-secondary" style="font-size: 12.5px;">
                Powered by Haute Couture Digital &bull; Proyek UKK RPL &copy; 2026
            </p>

        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
