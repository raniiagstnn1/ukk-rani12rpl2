<?php
session_start();
include 'koneksi.php';

$is_demo = isset($_GET['demo']) && $_GET['demo'] == 'true';
$data = null;

if ($is_demo) {
    $data = [
        'nama_usaha' => 'Nama UMKM',
        'tagline' => 'Slogan atau Tagline Usaha Anda di Sini',
        'bio' => 'Deskripsikan profil singkat usaha atau layanan salon Anda di bagian ini agar calon pelanggan lebih mengenal bisnis Anda.',
        'produk_unggulan' => 'Layanan Unggulan 1, Layanan Unggulan 2, Layanan Unggulan 3',
        'alamat' => '', // Kosong saat demo
        'no_wa' => '6281234567890',
        'logo' => '',
        'foto_produk' => '',
        'template' => 'template1'
    ];
} else {
    $slug = isset($_GET['slug']) ? mysqli_real_escape_string($koneksi, $_GET['slug']) : '';
    $query = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE slug = '$slug' AND status = 'Aktif'");
    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
    } else {
        echo "<h3 style='text-align:center;margin-top:50px;font-family:sans-serif;'>Maaf, website salon tidak ditemukan.</h3>";
        exit;
    }
}
$link_wa = "https://wa.me/" . preg_replace('/[^0-9]/', '', $data['no_wa']) . "?text=Halo%20" . urlencode($data['nama_usaha']) . ",%20saya%20ingin%20reservasi.";
$alamat_tampil = !empty($data['alamat']) ? $data['alamat'] : (!$is_demo ? 'Alamat belum diatur' : '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama_usaha']); ?> - Template 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0d0707; color: #f8fafc; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .navbar-custom { background: rgba(13, 7, 7, 0.9); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(128,0,0,0.3); }
        .hero-section { padding: 80px 0; background: linear-gradient(135deg, #1c0606 0%, #0d0707 100%); }
        .btn-maroon { background: #800000; color: #fff; font-weight: 700; border-radius: 50px; padding: 12px 32px; border: 1px solid #a30000; box-shadow: 0 10px 25px rgba(128,0,0,0.4); transition: 0.3s; }
        .btn-maroon:hover { background: #a30000; color: #fff; transform: translateY(-2px); }
        .card-custom { background: #160a0a; border: 1px solid rgba(128,0,0,0.25); border-radius: 24px; padding: 35px; }
        .contact-box { background: rgba(128, 0, 0, 0.12); border: 1px solid rgba(128, 0, 0, 0.3); border-radius: 16px; padding: 18px 22px; margin-top: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
            <span class="navbar-brand fw-bold fs-4 font-serif text-danger mb-0"><?= htmlspecialchars($data['nama_usaha']); ?></span>
            <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-maroon btn-sm"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-danger bg-opacity-25 text-danger px-3 py-2 rounded-pill mb-3 font-serif">✨ Luxury & Elegance Care</span>
                    <h1 class="display-4 fw-bold font-serif mb-3 text-white" style="line-height: 1.2;"><?= htmlspecialchars($data['tagline']); ?></h1>
                    <p class="text-secondary fs-6 mb-3"><?= nl2br(htmlspecialchars($data['bio'])); ?></p>
                    
                    <!-- KOTAK ALAMAT (Hanya tampil jika ada isinya atau bukan mode demo kosong) -->
                    <?php if (!empty($alamat_tampil)): ?>
                    <div class="contact-box">
                        <div class="d-flex align-items-start gap-2 mb-2 text-white">
                            <i class="bi bi-geo-alt-fill text-danger fs-5 mt-1"></i>
                            <div>
                                <strong class="small d-block text-danger">Lokasi / Alamat :</strong>
                                <span class="text-secondary small"><?= htmlspecialchars($alamat_tampil); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-maroon btn-lg w-100 py-3">
                            <i class="bi bi-whatsapp me-2"></i> Reservasi Sesi via WhatsApp
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <?php if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])): ?>
                        <img src="uploads/<?= $data['foto_produk']; ?>" class="rounded-4 img-fluid shadow-lg" style="max-height: 380px; width: 100%; object-fit: cover; border: 2px solid rgba(128,0,0,0.4);">
                    <?php else: ?>
                        <div class="rounded-4 bg-black py-5 border border-danger border-opacity-25 text-secondary d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
                            <i class="bi bi-image display-2 text-danger opacity-50"></i>
                            <p class="mt-3 text-secondary small">[ Area Foto / Banner Usaha ]</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="card-custom text-center py-5">
            <h3 class="font-serif text-danger mb-3">Layanan & Produk Unggulan</h3>
            <p class="fs-4 text-white fw-semibold mb-0"><?= htmlspecialchars($data['produk_unggulan']); ?></p>
        </div>
    </main>

    <footer class="text-center py-4 text-secondary border-top border-dark mt-5">
        <p class="small mb-0">&copy; 2026 <?= htmlspecialchars($data['nama_usaha']); ?> &bull; Beauty Digital Hub</p>
    </footer>
</body>
</html>