
<?php
session_start();
include 'koneksi.php';

$is_demo = isset($_GET['demo']) && $_GET['demo'] == 'true';
$data = null;

if ($is_demo) {
    $data = [
        'id_portfolio' => 0,
        'nama_usaha' => 'Lumière Haute Couture Salon',
        'tagline' => 'The Pinnacle of Elite Beauty & Aesthetic Care',
        'bio' => 'Experience bespoke luxury treatments crafted exclusively for discerning clients seeking perfection in every detail.',
        'produk_unggulan' => 'Royal Gold Facial, Diamond Hair Spa, Signature Keratin',
        'alamat' => 'Boulevard St. Honoré, Elite District',
        'no_wa' => '6281234567890',
        'logo' => '',
        'foto_produk' => '',
        'template' => 'template1'
    ];
} else {
    if (isset($_GET['slug']) && !empty($_GET['slug'])) {
        $slug = mysqli_real_escape_string($koneksi, $_GET['slug']);
        $query = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE slug = '$slug' AND status = 'Aktif'");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE status = 'Aktif' ORDER BY id_portfolio DESC LIMIT 1");
    }

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
    } else {
        echo "<h3 style='text-align:center;margin-top:50px;font-family:sans-serif;'>Maaf, website salon tidak ditemukan atau status belum Aktif.</h3>";
        exit;
    }
}

$link_wa = "https://wa.me/" . preg_replace('/[^0-9]/', '', $data['no_wa']) . "?text=Halo%20" . urlencode($data['nama_usaha']) . ",%20saya%20tertarik%20dengan%20layanan%20eksklusif%20Anda.";

$alamat_tampil = !empty($data['alamat']) ? $data['alamat'] : (!$is_demo ? 'Alamat belum diatur' : '');
$id_port = isset($data['id_portfolio']) ? $data['id_portfolio'] : 0;

$query_img = null;
if (!$is_demo && $id_port > 0) {
    $query_img = mysqli_query($koneksi, "SELECT * FROM portfolio_images WHERE portfolio_id = '$id_port'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama_usaha']); ?> - Plum & Silver Edition</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #100b16;
            --bg-plum: #1c1225;
            --bg-card: #24182e;
            --plum-light: #493354;
            --silver: #dce0e8;
            --silver-light: #f5f6fa;
            --silver-muted: #aeb4c2;
            --silver-glow: rgba(210, 216, 230, 0.18);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(ellipse at 85% 8%, rgba(111, 77, 133, 0.22), transparent 35%),
                radial-gradient(ellipse at 8% 55%, rgba(75, 48, 93, 0.18), transparent 40%),
                var(--bg-dark);
            color: var(--silver-light);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }

        .navbar-custom {
            background: rgba(16, 11, 22, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(220, 224, 232, 0.18);
        }

        .navbar-brand {
            color: var(--silver-light) !important;
            letter-spacing: 0.5px;
        }

        .hero-section {
            padding: 80px 0;
            background:
                radial-gradient(circle at top right, rgba(91, 61, 111, 0.35), transparent 45%),
                linear-gradient(135deg, #100b16, #1c1225 65%, #120d19);
        }

        .btn-silver {
            background: linear-gradient(135deg, #f2f3f7 0%, #c5cad5 50%, #969eae 100%);
            color: #21172a;
            font-weight: 700;
            border-radius: 50px;
            padding: 14px 36px;
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 10px 30px rgba(190, 198, 215, 0.16);
            transition: 0.3s;
        }

        .btn-silver:hover {
            background: linear-gradient(135deg, #ffffff, #dce0e8);
            color: #21172a;
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(190, 198, 215, 0.28);
        }

        .btn-silver-outline {
            background: rgba(36, 24, 46, 0.55);
            border: 1px solid rgba(220, 224, 232, 0.45);
            color: var(--silver-light);
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-silver-outline:hover {
            background: rgba(220, 224, 232, 0.12);
            border-color: var(--silver-light);
            color: #fff;
        }

        .badge-plum {
            background: rgba(170, 145, 190, 0.12);
            color: var(--silver-light);
            border: 1px solid rgba(220, 224, 232, 0.28);
            letter-spacing: 2px;
        }

        .text-silver {
            color: var(--silver) !important;
        }

        .hero-title {
            color: var(--silver-light);
            text-shadow: 0 0 28px rgba(210, 216, 230, 0.13);
        }

        .card-custom {
            background: linear-gradient(145deg, #291d34, #1b1224);
            border: 1px solid rgba(220, 224, 232, 0.20);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }

        .contact-box {
            background: rgba(220, 224, 232, 0.045);
            border: 1px solid rgba(220, 224, 232, 0.20);
            border-radius: 16px;
            padding: 20px;
            margin-top: 25px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .portfolio-card-item {
            background: #24182e;
            border: 1px solid rgba(220, 224, 232, 0.22);
            border-radius: 16px;
            overflow: hidden;
            padding: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .portfolio-card-item:hover {
            transform: translateY(-5px);
            border-color: rgba(220, 224, 232, 0.55);
        }

        .portfolio-img-box {
            width: 100%;
            height: 210px;
            border-radius: 12px;
            overflow: hidden;
            background: #34243f;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .portfolio-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.5s ease;
        }

        .portfolio-card-item:hover .portfolio-img-box img {
            transform: scale(1.06);
        }

        .showcase-placeholder {
            width: 100%;
            min-height: 210px;
            grid-column: span 2;
            background: linear-gradient(145deg, #2b1e36, #17101f);
            border: 1px solid rgba(220, 224, 232, 0.25);
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--silver-muted);
        }

        footer {
            background: #0b0710;
            border-top: 1px solid rgba(220, 224, 232, 0.18);
            padding: 35px 0;
            color: var(--silver-muted);
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 52px 0;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .navbar-brand {
                font-size: 17px !important;
                text-align: center;
            }

            .card-custom {
                padding: 22px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .showcase-placeholder {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">

            <a href="index.php" class="btn btn-silver-outline btn-sm rounded-pill px-3 py-2">
                <i class="bi bi-arrow-left me-1"></i> Home
            </a>

            <span class="navbar-brand fw-bold fs-4 font-serif mb-0">
                <?= htmlspecialchars($data['nama_usaha']); ?>
            </span>

            <a href="<?= htmlspecialchars($link_wa); ?>" target="_blank" class="btn btn-silver btn-sm">
                <i class="bi bi-whatsapp me-1"></i> Concierge
            </a>

        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">

                    <span class="badge badge-plum px-3 py-2 rounded-pill mb-3 font-serif">
                        <i class="bi bi-stars me-1"></i> ELITE LUXURY EXPERIENCE
                    </span>

                    <h1 class="display-4 fw-bold font-serif mb-4 hero-title" style="line-height: 1.15;">
                        <?= htmlspecialchars($data['tagline']); ?>
                    </h1>

                    <p class="text-secondary fs-6 mb-4" style="font-weight: 300; line-height: 1.8;">
                        <?= nl2br(htmlspecialchars($data['bio'])); ?>
                    </p>

                    <?php if (!empty($alamat_tampil)): ?>
                        <div class="contact-box">
                            <div class="d-flex align-items-start gap-3 text-white">
                                <i class="bi bi-geo-alt-fill text-silver fs-4 mt-1"></i>

                                <div>
                                    <strong class="small d-block text-silver font-serif fs-6">
                                        Exclusive Location:
                                    </strong>

                                    <span class="text-secondary small">
                                        <?= htmlspecialchars($alamat_tampil); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="<?= htmlspecialchars($link_wa); ?>" target="_blank" class="btn btn-silver btn-lg w-100 py-3 shadow">
                            <i class="bi bi-calendar-check me-2"></i>
                            Book Private Appointment
                        </a>
                    </div>

                </div>

                <div class="col-lg-6">

                    <h5 class="text-silver font-serif mb-3 fs-4">
                        <i class="bi bi-stars me-1"></i>
                        Signature Treatments & Gallery
                    </h5>

                    <div class="gallery-grid">

                        <?php
                        $ada_foto = false;

                        if ($query_img && mysqli_num_rows($query_img) > 0) {
                            while ($img = mysqli_fetch_assoc($query_img)) {
                                $namaFoto = basename($img['foto']);
                                $pathFoto = "uploads/" . $namaFoto;

                                if (is_file($pathFoto)) {
                                    $ada_foto = true;
                                    ?>
                                    <div class="portfolio-card-item">
                                        <div class="portfolio-img-box">
                                            <img src="<?= htmlspecialchars($pathFoto); ?>" alt="Luxury Portfolio">
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }

                        if (!$ada_foto && !empty($data['foto_produk'])) {
                            $fotoProduk = basename($data['foto_produk']);
                            $pathProduk = "uploads/" . $fotoProduk;

                            if (is_file($pathProduk)) {
                                $ada_foto = true;
                                ?>
                                <div class="portfolio-card-item">
                                    <div class="portfolio-img-box">
                                        <img src="<?= htmlspecialchars($pathProduk); ?>" alt="Main Product">
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        if (!$ada_foto && !empty($data['logo'])) {
                            $logo = basename($data['logo']);
                            $pathLogo = "uploads/" . $logo;

                            if (is_file($pathLogo)) {
                                $ada_foto = true;
                                ?>
                                <div class="portfolio-card-item">
                                    <div class="portfolio-img-box">
                                        <img src="<?= htmlspecialchars($pathLogo); ?>" alt="Logo <?= htmlspecialchars($data['nama_usaha']); ?>" style="object-fit:contain;padding:20px;">
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        if (!$ada_foto):
                        ?>
                            <div class="showcase-placeholder">
                                <i class="bi bi-gem display-4 text-silver opacity-75"></i>
                                <p class="mt-2 small font-serif">[ Private Showcase Preview ]</p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </header>

    <main class="container py-4">
        <div class="card-custom text-center py-5">
            <h3 class="font-serif text-silver mb-3 fs-2">
                Signature Core Services
            </h3>

            <p class="fs-5 text-white font-serif mb-0">
                <?= htmlspecialchars($data['produk_unggulan']); ?>
            </p>
        </div>
    </main>

    <footer class="text-center py-4 mt-5">
        <p class="small mb-0 font-serif">
            &copy; 2026 <?= htmlspecialchars($data['nama_usaha']); ?>
            &bull; Haute Couture Digital Experience
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
