<?php
/**
 * =================================================================
 * LANDING PAGE PUBLIK - BEAUTY DIGITAL HUB
 * Layout Split (Teks di Kiri, Gradasi Visual Estetik di Kanan)
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
    <title>Beauty Digital Hub - Jasa Pembuatan Website UMKM Salon Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0714;
            --bg-card: #130f24;
            --accent-purple-1: #8b5cf6;
            --accent-purple-2: #c084fc;
            --text-bright: #f8fafc;
            --text-soft: #cbd5e1;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #07050f 0%, #120b22 50%, #1a1033 100%);
            color: var(--text-bright);
            min-height: 100vh;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar {
            background: rgba(10, 7, 20, 0.9) !important;
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(139, 92, 246, 0.15);
        }
        .nav-link {
            color: var(--text-soft) !important;
            font-weight: 500;
            font-size: 14px;
            transition: 0.2s;
        }
        .nav-link:hover {
            color: #c084fc !important;
        }

        /* Hero Section Split (Kiri Teks, Kanan Gradasi Visual 3D) */
        .hero-section {
            padding: 80px 0;
            position: relative;
        }
        .hero-badge {
            background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.4);
            color: #d8b4fe;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 18px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .hero-title {
            font-size: 3.1rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 18px;
            color: #ffffff;
        }
        .hero-title span {
            background: linear-gradient(135deg, #c084fc 0%, #e879f9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-subtitle {
            color: var(--text-soft);
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        /* Elemen Gradasi Estetik di Sebelah Kanan */
        .hero-visual-wrapper {
            position: relative;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glowing-orb-1 {
            position: absolute;
            width: 280px;
            height: 280px;
            background: linear-gradient(135deg, #7c3aed, #c084fc);
            filter: blur(70px);
            opacity: 0.55;
            border-radius: 50%;
            z-index: 1;
        }
        .glowing-orb-2 {
            position: absolute;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #a855f7, #ec4899);
            filter: blur(60px);
            opacity: 0.45;
            border-radius: 50%;
            top: 40px;
            right: 30px;
            z-index: 1;
        }
        .floating-card-visual {
            position: relative;
            z-index: 2;
            background: rgba(19, 15, 36, 0.75);
            border: 1.5px solid rgba(168, 85, 247, 0.35);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
        }

        /* Buttons (Gradasi Ungu Mewah) */
        .btn-gradient {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            padding: 12px 28px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.35);
            transition: 0.3s;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(124, 58, 237, 0.5);
        }
        .btn-outline-glow {
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid rgba(139, 92, 246, 0.35);
            color: #ffffff !important;
            border-radius: 50px;
            padding: 12px 28px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-outline-glow:hover {
            background: rgba(139, 92, 246, 0.15);
            border-color: #a855f7;
        }

        /* Section Headings */
        .section-heading {
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 10px;
        }
        .section-sub {
            color: var(--text-soft);
            font-size: 15px;
            margin-bottom: 40px;
        }

        /* Card Umum */
        .card-glass {
            background: var(--bg-card);
            border: 1px solid rgba(139, 92, 246, 0.15);
            border-radius: 24px;
            padding: 28px;
            height: 100%;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            transition: 0.3s;
        }
        .card-glass:hover {
            transform: translateY(-6px);
            border-color: rgba(168, 85, 247, 0.5);
        }
        .icon-box {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.25), rgba(168, 85, 247, 0.25));
            border: 1px solid rgba(139, 92, 246, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #d8b4fe;
            margin-bottom: 20px;
        }
        .card-glass h5 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .card-glass p {
            color: var(--text-soft);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Card Katalog Klien & Template */
        .card-portfolio {
            background: var(--bg-card);
            border: 1px solid rgba(139, 92, 246, 0.15);
            border-radius: 24px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            transition: 0.3s;
        }
        .card-portfolio:hover {
            transform: translateY(-6px);
            border-color: rgba(168, 85, 247, 0.5);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid rgba(139, 92, 246, 0.15);
        }
        .template-preview-banner {
            height: 160px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(139, 92, 246, 0.15);
        }

        /* CTA Banner */
        .cta-box {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.2) 0%, rgba(168, 85, 247, 0.25) 100%);
            border: 1px solid rgba(139, 92, 246, 0.4);
            border-radius: 28px;
            padding: 50px 35px;
            text-align: center;
        }

        footer {
            background: #07050f;
            border-top: 1px solid rgba(139, 92, 246, 0.15);
            padding: 35px 0;
            color: var(--text-soft);
            font-size: 13.5px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR PUBLIK -->
    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 text-white text-decoration-none" href="index.php">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow" style="width:38px;height:38px;background:linear-gradient(135deg, #7c3aed, #a855f7);">
                    <i class="bi bi-stars"></i>
                </div>
                <span style="font-size: 18px;">Beauty Digital Hub</span>
            </a>

            <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-3">
                    <li class="nav-item"><a class="nav-link" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#template">Pilihan Desain</a></li>
                    <li class="nav-item"><a class="nav-link" href="#katalog">Portofolio Klien</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cara-pesan">Cara Pemesanan</a></li>
                </ul>
                <a href="https://wa.me/6281234567890?text=Halo%20Beauty%20Digital%20Hub,%20saya%20tertarik%20membuat%20website%20untuk%20usaha%20UMKM%20saya." target="_blank" class="btn btn-gradient btn-sm px-4 py-2">
                    <i class="bi bi-whatsapp me-1"></i> Buat Website Sekarang
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (TEKS DI KIRI, GRADASI VISUAL 3D DI KANAN) -->
    <header class="hero-section container">
        <div class="row align-items-center g-5">
            <!-- Sisi Kiri: Teks & Tombol -->
            <div class="col-lg-7 text-start">
                <div class="hero-badge">
                    <i class="bi bi-rocket-takeoff-fill me-1"></i> Solusi Digitalisasi UMKM Salon, Kecantikan & Jasa
                </div>
                <h1 class="hero-title">Tingkatkan Omzet UMKM Anda dengan <span>Website Profesional</span></h1>
                <p class="hero-subtitle">
                    Buat bisnis salon dan usaha lokal Anda tampil lebih terpercaya, mudah ditemukan pelanggan, dan siap menerima booking layanan langsung melalui WhatsApp dalam hitungan menit.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#template" class="btn btn-gradient">
                        <i class="bi bi-palette-fill me-2"></i>Lihat Pilihan Desain
                    </a>
                    <a href="#katalog" class="btn btn-outline-glow">
                        <i class="bi bi-shop me-2"></i>Lihat Website Klien Kami
                    </a>
                </div>
            </div>

            <!-- Sisi Kanan: Gradasi Visual Bola Cahaya & Floating Card Estetik -->
            <div class="col-lg-5">
                <div class="hero-visual-wrapper">
                    <div class="glowing-orb-1"></div>
                    <div class="glowing-orb-2"></div>
                    <div class="floating-card-visual text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-3 shadow" style="width:65px;height:65px;background:linear-gradient(135deg, #7c3aed, #a855f7); font-size: 28px;">
                            <i class="bi bi-gem"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-2">Beauty Digital Hub</h4>
                        <p class="small text-secondary mb-4">Platform Pembuatan Website Salon & UMKM Berstandar Profesional</p>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-purple bg-opacity-25 text-purple px-3 py-2 rounded-pill" style="background:rgba(139,92,246,0.2); color:#d8b4fe; font-size:11.5px;">✓ Mobile Friendly</span>
                            <span class="badge bg-purple bg-opacity-25 text-purple px-3 py-2 rounded-pill" style="background:rgba(139,92,246,0.2); color:#d8b4fe; font-size:11.5px;">✓ Auto WhatsApp</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- SECTION 1: KEUNGGULAN -->
    <section id="keunggulan" class="container py-5">
        <div class="text-center">
            <h2 class="section-heading">Kenapa UMKM Harus Punya Website Sendiri?</h2>
            <p class="section-sub">Fitur lengkap yang dirancang khusus untuk membantu usaha Anda berkembang lebih cepat.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-glass">
                    <div class="icon-box"><i class="bi bi-whatsapp"></i></div>
                    <h5>Booking Langsung ke WhatsApp</h5>
                    <p>Pelanggan cukup klik satu tombol untuk memilih layanan dan langsung terhubung ke nomor WhatsApp usaha Anda tanpa ribet.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-glass">
                    <div class="icon-box"><i class="bi bi-phone"></i></div>
                    <h5>Tampilan Mewah & Mobile Friendly</h5>
                    <p>Desain modern yang tampil rapi dan elegan baik dibuka lewat smartphone pelanggan maupun layar komputer.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-glass">
                    <div class="icon-box"><i class="bi bi-award"></i></div>
                    <h5>Meningkatkan Kepercayaan Klien</h5>
                    <p>Katalog layanan, profil usaha, dan galeri foto produk tersusun profesional sehingga calon pelanggan lebih yakin memilih Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: PILIHAN DESAIN TEMPLATE DEMO -->
    <section id="template" class="container py-5">
        <div class="text-center">
            <h2 class="section-heading">Pilih Desain Website Sesuai Karakter Usaha Anda</h2>
            <p class="section-sub">Coba langsung tampilan demo interaktif di bawah ini sebelum memesan.</p>
        </div>
        <div class="row g-4">
            <!-- Demo Template 1 -->
            <div class="col-md-4">
                <div class="card-portfolio">
                    <div class="template-preview-banner" style="background: linear-gradient(135deg, #2b0505, #160a0a);">
                        <i class="bi bi-gem fs-1 text-danger mb-2"></i>
                        <span class="badge bg-danger bg-opacity-25 text-danger rounded-pill px-3">Template 1 (Maroon)</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold text-white mb-2">Luxury & Elegance</h5>
                        <p class="small mb-4" style="color: #cbd5e1;">Nuansa maroon mewah dan berkelas, cocok untuk salon eksklusif.</p>
                        <a href="template1.php?demo=true" target="_blank" class="btn btn-outline-glow w-100 mt-auto">
                            <i class="bi bi-eye me-1"></i> Lihat Demo Template 1
                        </a>
                    </div>
                </div>
            </div>
            <!-- Demo Template 2 -->
            <div class="col-md-4">
                <div class="card-portfolio">
                    <div class="template-preview-banner" style="background: linear-gradient(135deg, #2b0c1b, #160f13);">
                        <i class="bi bi-heart-fill fs-1 mb-2" style="color:#ff8fab;"></i>
                        <span class="badge rounded-pill px-3" style="background:rgba(255,143,171,0.2); color:#ff8fab;">Template 2 (Soft Pink)</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold text-white mb-2">Soft Pastel Beauty</h5>
                        <p class="small mb-4" style="color: #cbd5e1;">Nuansa soft pink feminin dan estetik, sangat pas untuk nail art & eyelash studio.</p>
                        <a href="template2.php?demo=true" target="_blank" class="btn btn-outline-glow w-100 mt-auto">
                            <i class="bi bi-eye me-1"></i> Lihat Demo Template 2
                        </a>
                    </div>
                </div>
            </div>
            <!-- Demo Template 3 -->
            <div class="col-md-4">
                <div class="card-portfolio">
                    <div class="template-preview-banner" style="background: linear-gradient(135deg, #1e293b, #0b0c0e);">
                        <i class="bi bi-cloud-haze2 fs-1 text-silver mb-2" style="color:#cbd5e1;"></i>
                        <span class="badge bg-secondary bg-opacity-25 text-silver rounded-pill px-3">Template 3 (Grey)</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold text-white mb-2">Minimalist Urban Grey</h5>
                        <p class="small mb-4" style="color: #cbd5e1;">Konsep tenang, minimalis, dan profesional untuk layanan spa & relaksasi.</p>
                        <a href="template3.php?demo=true" target="_blank" class="btn btn-outline-glow w-100 mt-auto">
                            <i class="bi bi-eye me-1"></i> Lihat Demo Template 3
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: KATALOG PORTOFOLIO KLIEN -->
    <section id="katalog" class="container py-5">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 pb-2 border-bottom border-light border-opacity-10">
            <div>
                <h2 class="section-heading mb-1">UMKM & Salon yang Telah Bergabung</h2>
                <p class="mb-0" style="color: #cbd5e1; font-size: 14.5px;">Lihat website resmi milik mitra UMKM yang telah aktif online.</p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(139,92,246,0.2); color: #d8b4fe;">
                <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi Aktif
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
                    <?php if (!empty($row['foto_produk']) && file_exists("uploads/" . $row['foto_produk'])): ?>
                        <img src="uploads/<?= $row['foto_produk']; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_usaha']); ?>">
                    <?php elseif (!empty($row['logo']) && file_exists("uploads/" . $row['logo'])): ?>
                        <img src="uploads/<?= $row['logo']; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_usaha']); ?>" style="object-fit: contain; background: #0a0714; padding: 20px;">
                    <?php else: ?>
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="background: #120b22; color: #cbd5e1;">
                            <i class="bi bi-shop fs-1"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light bg-opacity-10 text-white" style="font-size: 11px;"><?= htmlspecialchars($row['template']); ?></span>
                            <span class="badge bg-success bg-opacity-25 text-info" style="font-size: 11px;"><i class="bi bi-circle-fill me-1" style="font-size:7px;"></i>Online</span>
                        </div>
                        <h4 class="fw-bold text-white mb-2"><?= htmlspecialchars($row['nama_usaha']); ?></h4>
                        <p class="small mb-4 flex-grow-1" style="color: #cbd5e1;"><?= htmlspecialchars($row['tagline']); ?></p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-light border-opacity-10">
                            <span class="small text-white"><i class="bi bi-whatsapp text-success me-1"></i><?= htmlspecialchars($row['no_wa'] ?: 'Tersedia'); ?></span>
                            <a href="<?= $t_file; ?>?slug=<?= $row['slug']; ?>" target="_blank" class="btn btn-gradient btn-sm px-3 py-2">
                                Kunjungi Web <i class="bi bi-arrow-up-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } } else { ?>
            <div class="col-12">
                <div class="card-glass text-center py-5">
                    <i class="bi bi-shop text-white fs-1 mb-3 d-block"></i>
                    <h5 class="text-white fw-bold">Belum Ada Website Klien yang Diterbitkan</h5>
                    <p style="color: #cbd5e1;">Jadilah mitra UMKM pertama yang memiliki website promosi profesional bersama kami!</p>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>

    <!-- SECTION 4: CARA PEMESANAN -->
    <section id="cara-pesan" class="container py-5">
        <div class="text-center">
            <h2 class="section-heading">3 Langkah Mudah Punya Website Sendiri</h2>
            <p class="section-sub">Proses cepat tanpa perlu paham coding sama sekali.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card-glass">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold fs-4 text-white" style="width:52px;height:52px;background:linear-gradient(135deg,#7c3aed,#a855f7);">1</div>
                    <h5>Pilih Desain Template</h5>
                    <p>Tentukan gaya tampilan website yang paling sesuai dengan identitas brand dan jenis layanan salon Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-glass">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold fs-4 text-white" style="width:52px;height:52px;background:linear-gradient(135deg,#7c3aed,#a855f7);">2</div>
                    <h5>Kirim Profil & Foto Produk</h5>
                    <p>Siapkan nama usaha, daftar layanan unggulan, nomor WhatsApp, serta logo atau foto hasil perawatan terbaik.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-glass">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold fs-4 text-white" style="width:52px;height:52px;background:linear-gradient(135deg,#7c3aed,#a855f7);">3</div>
                    <h5>Website Siap Disebarkan</h5>
                    <p>Website langsung aktif dan link siap dibagikan ke bio Instagram, TikTok, maupun status WhatsApp Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: CTA -->
    <section class="container py-5">
        <div class="cta-box">
            <h2 class="fw-bold text-white mb-3">Siap Membuat Usaha UMKM Anda Naik Kelas?</h2>
            <p class="mx-auto mb-4" style="color: #e2e8f0; max-width: 620px; font-size: 15.5px;">
                Konsultasikan kebutuhan website promosi Anda sekarang. Dapatkan halaman profil usaha elegan yang siap mendatangkan lebih banyak pelanggan baru setiap hari.
            </p>
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Beauty%20Digital%20Hub,%20saya%20ingin%20konsultasi%20pembuatan%20website%20untuk%20UMKM%20saya." target="_blank" class="btn btn-gradient px-5 py-3">
                <i class="bi bi-whatsapp me-2"></i>Hubungi Kami via WhatsApp
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <p class="fw-semibold text-white mb-1">Beauty Digital Hub &mdash; Platform Digitalisasi UMKM & Jasa Kecantikan</p>
            <p class="mb-0" style="color: #cbd5e1;">&copy; 2026 Proyek UKK Rekayasa Perangkat Lunak (RPL) &bull; Rani Agustin</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>