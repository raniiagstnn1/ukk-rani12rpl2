<?php
/**
 * =================================================================
 * LANDING PAGE PUBLIK - LUXURY BLACK & GOLD EDITION
 * =================================================================
 */
include 'koneksi.php';

// Ambil portofolio klien yang berstatus Aktif
$query_portfolios = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE status = 'Aktif' ORDER BY id_portfolio DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haute Couture Digital - Luxury Web Agency & Templates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #060608;
            --bg-card: #0d0d12;
            --gold-primary: #d4af37;
            --gold-light: #f3e5ab;
            --gold-dark: #aa771c;
            --text-bright: #f8fafc;
            --text-soft: #94a3b8;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #12100e 0%, #060608 70%);
            color: var(--text-bright);
            min-height: 100vh;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(6, 6, 8, 0.95);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.25);
        }
        .nav-link {
            color: var(--text-soft) !important;
            font-weight: 500;
            font-size: 14px;
            transition: 0.2s;
        }
        .nav-link:hover {
            color: var(--gold-primary) !important;
        }

        /* Hero Section */
        .hero-section {
            padding: 90px 0;
            position: relative;
        }
        .hero-badge {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.35);
            color: var(--gold-light);
            font-weight: 600;
            font-size: 13px;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }
        .hero-title {
            font-size: 3.2rem;
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 20px;
            color: #ffffff;
            font-family: 'Cormorant Garamond', serif;
        }
        .hero-title span {
            background: linear-gradient(135deg, #f3e5ab 0%, #d4af37 50%, #aa771c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-subtitle {
            color: var(--text-soft);
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 35px;
            font-weight: 300;
        }

        /* Hero Visual Orb */
        .hero-visual-wrapper {
            position: relative;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glowing-orb-1 {
            position: absolute;
            width: 260px;
            height: 260px;
            background: linear-gradient(135deg, #d4af37, #aa771c);
            filter: blur(80px);
            opacity: 0.25;
            border-radius: 50%;
            z-index: 1;
        }
        .floating-card-visual {
            position: relative;
            z-index: 2;
            background: rgba(13, 13, 18, 0.85);
            border: 1.5px solid rgba(212, 175, 55, 0.35);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            padding: 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
        }

        /* Buttons Gold */
        .btn-gold {
            background: linear-gradient(135deg, #d4af37 0%, #aa771c 100%);
            color: #060608 !important;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
            transition: 0.3s;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #e5c158 0%, #c48b22 100%);
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(212, 175, 55, 0.45);
        }
        .btn-outline-gold {
            background: transparent;
            border: 1.5px solid rgba(212, 175, 55, 0.4);
            color: var(--gold-light) !important;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-outline-gold:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--gold-primary);
            color: #ffffff !important;
        }

        /* Section Headings */
        .section-heading {
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            font-family: 'Cormorant Garamond', serif;
        }
        .section-sub {
            color: var(--text-soft);
            font-size: 15px;
            margin-bottom: 45px;
            font-weight: 300;
        }

        /* Card Umum */
        .card-lux {
            background: var(--bg-card);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 24px;
            padding: 30px;
            height: 100%;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            transition: 0.3s;
        }
        .card-lux:hover {
            transform: translateY(-6px);
            border-color: rgba(212, 175, 55, 0.5);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.15);
        }
        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(170, 119, 28, 0.15));
            border: 1px solid rgba(212, 175, 55, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--gold-light);
            margin-bottom: 20px;
        }

        /* Card Portfolio & Template */
        .card-portfolio {
            background: var(--bg-card);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 24px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            transition: 0.3s;
        }
        .card-portfolio:hover {
            transform: translateY(-6px);
            border-color: rgba(212, 175, 55, 0.6);
            box-shadow: 0 20px 45px rgba(212, 175, 55, 0.2);
        }
        .card-img-wrapper {
            width: 100%;
            height: 210px;
            background: #060608;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .card-portfolio:hover .card-img-top {
            transform: scale(1.06);
        }
        .template-preview-banner {
            height: 160px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }

        /* CTA Banner */
        .cta-box {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.12) 0%, rgba(13, 13, 18, 0.95) 100%);
            border: 1.5px solid rgba(212, 175, 55, 0.35);
            border-radius: 28px;
            padding: 50px 35px;
            text-align: center;
        }

        footer {
            background: #040405;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            padding: 35px 0;
            color: var(--text-soft);
            font-size: 13.5px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR PUBLIK -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 text-white text-decoration-none font-serif" href="index.php">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-dark shadow" style="width:38px;height:38px;background:linear-gradient(135deg, #d4af37, #aa771c);">
                    <i class="bi bi-stars"></i>
                </div>
                <span style="font-size: 20px; letter-spacing: 1px;">Haute Couture Digital</span>
            </a>

            <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-3">
                    <li class="nav-item"><a class="nav-link" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#template">Pilihan Desain & Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="#katalog">Portofolio Klien</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cara-pesan">Cara Pemesanan</a></li>
                </ul>
                <a href="https://wa.me/6281234567890?text=Halo%20Haute%20Couture%20Digital,%20saya%20tertarik%20membuat%20website%20eksklusif." target="_blank" class="btn btn-gold btn-sm px-4 py-2">
                    <i class="bi bi-whatsapp me-1"></i> Buat Website
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="hero-section container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-start">
                <div class="hero-badge font-serif">
                    <i class="bi bi-gem me-1"></i> EXCLUSIVE DIGITAL AGENCY & TEMPLATES
                </div>
                <h1 class="hero-title">Elevate Your Salon & Brand with <span>Luxury Web Presence</span></h1>
                <p class="hero-subtitle">
                    Hadirkan mahakarya digital berstandar haute couture untuk usaha salon dan kecantikan Anda. Tampil elit, berkelas dunia, dan siap menerima reservasi klien VIP langsung via WhatsApp.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#template" class="btn btn-gold">
                        <i class="bi bi-collection me-2"></i>Eksplorasi Katalog & Harga ($)
                    </a>
                    <a href="#katalog" class="btn btn-outline-gold">
                        <i class="bi bi-shop me-2"></i>Lihat Portofolio Klien
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hero-visual-wrapper">
                    <div class="glowing-orb-1"></div>
                    <div class="floating-card-visual text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-dark mb-3 shadow" style="width:65px;height:65px;background:linear-gradient(135deg, #d4af37, #aa771c); font-size: 28px;">
                            <i class="bi bi-award"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-2 font-serif" style="font-size: 24px;">Haute Couture Digital</h4>
                    <p class="small text-secondary mb-4">Platform Web Eksklusif Standar Internasional</p>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(212,175,55,0.12); color:#f3e5ab; font-size:11.5px; border:1px solid rgba(212,175,55,0.3);">✓ High-End Aesthetics</span>
                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(212,175,55,0.12); color:#f3e5ab; font-size:11.5px; border:1px solid rgba(212,175,55,0.3);">✓ VIP Booking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- SECTION 1: KEUNGGULAN -->
    <section id="keunggulan" class="container py-5">
        <div class="text-center">
            <h2 class="section-heading font-serif">Standar Kemewahan Digital Kami</h2>
            <p class="section-sub">Dirancang khusus untuk memberikan pengalaman visual kelas atas bagi pelanggan Anda.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-lux">
                    <div class="icon-box"><i class="bi bi-whatsapp"></i></div>
                    <h5 class="text-white fw-bold font-serif fs-4 mb-2">VIP WhatsApp Concierge</h5>
                    <p class="text-secondary small">Sistem pemesanan instan yang menghubungkan klien langsung ke layanan personal salon Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-lux">
                    <div class="icon-box"><i class="bi bi-phone"></i></div>
                    <h5 class="text-white fw-bold font-serif fs-4 mb-2">Responsive & Immersive</h5>
                    <p class="text-secondary small">Tampilan sempurna berstandar estetika tinggi di setiap perangkat smartphone maupun desktop.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-lux">
                    <div class="icon-box"><i class="bi bi-gem"></i></div>
                    <h5 class="text-white fw-bold font-serif fs-4 mb-2">Prestigious Branding</h5>
                    <p class="text-secondary small">Membangun citra eksklusif yang membuat brand salon Anda jauh lebih bernilai di mata klien.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: PILIHAN DESAIN TEMPLATE & HARGA MASING-MASING -->
    <section id="template" class="container py-5">
        <div class="text-center">
            <h2 class="section-heading font-serif">Katalog Mahakarya & Investasi Harga</h2>
            <p class="section-sub">Pilih desain eksklusif dengan rincian harga transparan dalam mata uang USD ($).</p>
        </div>
        <div class="row g-4">
            <!-- Template 1 -->
            <div class="col-md-4">
                <div class="card-portfolio">
                    <div class="template-preview-banner" style="background: linear-gradient(135deg, #1c150b, #0d0d12);">
                        <i class="bi bi-gem fs-1 mb-2" style="color: #d4af37;"></i>
                        <span class="badge rounded-pill px-3" style="background: rgba(212,175,55,0.15); color: #f3e5ab; border: 1px solid rgba(212,175,55,0.3);">Template 1 (Emerald Gold)</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold text-white font-serif fs-3 mb-1">Royal Emerald & Gold</h5>
                        <p class="small mb-3 text-secondary">Kesan sangat mewah dengan nuansa zamrud dan emas berkelas tinggi.</p>
                        <div class="mb-3 p-3 rounded-3" style="background: rgba(212,175,55,0.05); border: 1px solid rgba(212,175,55,0.2);">
                            <span class="text-secondary small d-block">Investment Package:</span>
                            <h3 class="fw-bold font-serif mb-0" style="color:#f3e5ab !important; font-size: 28px;">$150 <span class="fs-6 text-secondary fw-normal">/ project</span></h3>
                        </div>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="template1.php?demo=true" target="_blank" class="btn btn-outline-gold py-2">
                                <i class="bi bi-eye me-1"></i> Preview Demo Template 1
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template 2 -->
            <div class="col-md-4">
                <div class="card-portfolio" style="border-color: rgba(212,175,55,0.5);">
                    <div class="template-preview-banner" style="background: linear-gradient(135deg, #1a160e, #0d0d12);">
                        <i class="bi bi-stars fs-1 mb-2" style="color: #d4af37;"></i>
                        <span class="badge rounded-pill px-3" style="background: rgba(212,175,55,0.2); color: #f3e5ab; border: 1px solid rgba(212,175,55,0.4);">Template 2 (Platinum Midnight)</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold text-white font-serif fs-3 mb-1">Platinum Midnight</h5>
                        <p class="small mb-3 text-secondary">Tampilan modern, futuristis, dan profesional untuk klinik estetika.</p>
                        <div class="mb-3 p-3 rounded-3" style="background: rgba(212,175,55,0.05); border: 1px solid rgba(212,175,55,0.2);">
                            <span class="text-secondary small d-block">Investment Package:</span>
                            <h3 class="fw-bold font-serif mb-0" style="color:#f3e5ab !important; font-size: 28px;">$290 <span class="fs-6 text-secondary fw-normal">/ project</span></h3>
                        </div>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="template2.php?demo=true" target="_blank" class="btn btn-outline-gold py-2">
                                <i class="bi bi-eye me-1"></i> Preview Demo Template 2
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template 3 -->
            <div class="col-md-4">
                <div class="card-portfolio">
                    <div class="template-preview-banner" style="background: linear-gradient(135deg, #14141a, #0d0d12);">
                        <i class="bi bi-flower1 fs-1 mb-2" style="color: #d4af37;"></i>
                        <span class="badge rounded-pill px-3" style="background: rgba(212,175,55,0.15); color: #f3e5ab; border: 1px solid rgba(212,175,55,0.3);">Template 3 (Obsidian Minimalist)</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold text-white font-serif fs-3 mb-1">Obsidian Minimalist</h5>
                        <p class="small mb-3 text-secondary">Gaya minimalis bersih ala majalah mode dunia, fokus pada visual karya.</p>
                        <div class="mb-3 p-3 rounded-3" style="background: rgba(212,175,55,0.05); border: 1px solid rgba(212,175,55,0.2);">
                            <span class="text-secondary small d-block">Investment Package:</span>
                            <h3 class="fw-bold font-serif mb-0" style="color:#f3e5ab !important; font-size: 28px;">$350 <span class="fs-6 text-secondary fw-normal">/ project</span></h3>
                        </div>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="template3.php?demo=true" target="_blank" class="btn btn-outline-gold py-2">
                                <i class="bi bi-eye me-1"></i> Preview Demo Template 3
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: KATALOG PORTOFOLIO KLIEN -->
    <section id="katalog" class="container py-5">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 pb-2 border-bottom border-light border-opacity-10">
            <div>
                <h2 class="section-heading font-serif mb-1">Mitra VIP Salon & Klien Kami</h2>
                <p class="mb-0 text-secondary" style="font-size: 14.5px;">Jelajahi galeri website resmi milik mitra salon dan usaha kecantikan.</p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(212,175,55,0.12); color: #f3e5ab; border: 1px solid rgba(212,175,55,0.3);">
                <i class="bi bi-check-circle-fill me-1"></i> Verified Active Online
            </span>
        </div>

        <div class="row g-4">
            <?php 
            if ($query_portfolios && mysqli_num_rows($query_portfolios) > 0) {
                while ($row = mysqli_fetch_assoc($query_portfolios)) { 
                    $t_file = strtolower($row['template']) == 'template2' ? 'template2.php' : (strtolower($row['template']) == 'template3' ? 'template3.php' : 'template1.php');
            ?>
            <div class="col-md-4">
                <div class="card-portfolio">
                    <div class="card-img-wrapper" style="background: #060608;">
                        <?php if (!empty($row['foto_produk']) && file_exists("uploads/" . $row['foto_produk'])): ?>
                            <img src="uploads/<?= $row['foto_produk']; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_usaha']); ?>">
                        <?php elseif (!empty($row['logo']) && file_exists("uploads/" . $row['logo'])): ?>
                            <img src="uploads/<?= $row['logo']; ?>" style="max-width: 80%; max-height: 80%; object-fit: contain; filter: drop-shadow(0 0 12px rgba(212,175,55,0.25)); transition: transform 0.5s ease;" alt="<?= htmlspecialchars($row['nama_usaha']); ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center text-secondary">
                                <i class="bi bi-shop fs-1" style="color: #d4af37;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light bg-opacity-10 text-white" style="font-size: 11px;"><?= htmlspecialchars($row['template']); ?></span>
                            <span class="badge bg-success bg-opacity-25 text-info" style="font-size: 11px;"><i class="bi bi-circle-fill me-1" style="font-size:7px;"></i>Online</span>
                        </div>
                        <h4 class="fw-bold text-white font-serif fs-3 mb-2"><?= htmlspecialchars($row['nama_usaha']); ?></h4>
                        <p class="small mb-4 flex-grow-1 text-secondary"><?= htmlspecialchars($row['tagline']); ?></p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-light border-opacity-10">
                            <span class="small text-white"><i class="bi bi-whatsapp text-success me-1"></i><?= htmlspecialchars($row['no_wa'] ?: 'Tersedia'); ?></span>
                            <a href="<?= $t_file; ?>?slug=<?= $row['slug']; ?>" target="_blank" class="btn btn-gold btn-sm px-3 py-2">
                                Kunjungi Web <i class="bi bi-arrow-up-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } } else { ?>
            <div class="col-12">
                <div class="card-lux text-center py-5">
                    <i class="bi bi-shop fs-1 mb-3 d-block" style="color: #d4af37;"></i>
                    <h5 class="text-white fw-bold font-serif fs-3">Belum Ada Website Klien yang Diterbitkan</h5>
                    <p class="text-secondary">Jadilah mitra salon VIP pertama yang meluncurkan website eksklusif bersama kami!</p>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>

    <!-- SECTION 4: CARA PEMESANAN -->
    <section id="cara-pesan" class="container py-5">
        <div class="text-center">
            <h2 class="section-heading font-serif">3 Langkah Mudah Menuju Digitalisasi VIP</h2>
            <p class="section-sub">Proses pembuatan yang cepat, eksklusif, dan tanpa kerumitan teknis.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card-lux">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold fs-4 text-dark font-serif" style="width:54px;height:54px;background:linear-gradient(135deg,#d4af37,#aa771c);">1</div>
                    <h5 class="text-white fw-bold font-serif fs-4 mb-2">Pilih Edisi Template</h5>
                    <p class="text-secondary small">Tentukan gaya visual template mewah yang paling mewakili karakter salon Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-lux">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold fs-4 text-dark font-serif" style="width:54px;height:54px;background:linear-gradient(135deg,#d4af37,#aa771c);">2</div>
                    <h5 class="text-white fw-bold font-serif fs-4 mb-2">Kirim Profil & Layanan</h5>
                    <p class="text-secondary small">Sertakan nama usaha, kontak WhatsApp, serta daftar perawatan unggulan salon.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-lux">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold fs-4 text-dark font-serif" style="width:54px;height:54px;background:linear-gradient(135deg,#d4af37,#aa771c);">3</div>
                    <h5 class="text-white fw-bold font-serif fs-4 mb-2">Website Resmi Aktif</h5>
                    <p class="text-secondary small">Website siap diluncurkan dan dibagikan ke media sosial untuk menarik klien VIP.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: CTA -->
    <section class="container py-5">
        <div class="cta-box">
            <h2 class="fw-bold text-white font-serif display-6 mb-3">Siap Menjadikan Salon Anda yang Paling Bergengsi?</h2>
            <p class="mx-auto mb-4 text-secondary" style="max-width: 620px; font-size: 15.5px;">
                Konsultasikan kebutuhan website eksklusif Anda hari ini dan mulailah menarik lebih banyak pelanggan setia berkelas tinggi.
            </p>
            <a href="https://wa.me/6281234567890?text=Halo%20Haute%20Couture%20Digital,%20saya%20ingin%20konsultasi%20pembuatan%20website%20salon." target="_blank" class="btn btn-gold px-5 py-3 shadow">
                <i class="bi bi-whatsapp me-2"></i>Konsultasi via WhatsApp
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <p class="fw-semibold text-white mb-1 font-serif fs-5" style="color: #f3e5ab !important;">Haute Couture Digital &mdash; Elite Web Agency for Salons</p>
            <p class="mb-0 text-secondary">&copy; 2026 Proyek UKK Rekayasa Perangkat Lunak (RPL) &bull; Rani Agustin</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>