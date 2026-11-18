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
        'alamat' => '',
        'no_wa' => '6281234567890',
        'logo' => '',
        'foto_produk' => '',
        'template' => 'template3'
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
    <title><?= htmlspecialchars($data['nama_usaha']); ?> - Urban Grey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b0c0e; color: #fff; }
        .text-silver { color: #cbd5e1; }
        .landing-card { background: #15181c; border: 1.5px solid rgba(255,255,255,0.12); border-radius: 32px; padding: 40px; box-shadow: 0 25px 50px rgba(0,0,0,0.8); max-width: 800px; margin: 30px auto; }
        .btn-grey { background: linear-gradient(135deg, #334155, #1e293b); color: #fff; font-weight: 700; border-radius: 50px; padding: 14px 35px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 10px 25px rgba(0,0,0,0.5); transition: 0.3s; }
        .btn-grey:hover { background: #475569; transform: translateY(-2px); color: #fff; }
    </style>
</head>
<body>
    <div class="container py-4">
        <div style="max-width: 800px; margin: 0 auto 15px auto;">
            <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>

        <div class="landing-card">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div>
                    <span class="badge bg-secondary bg-opacity-25 text-silver px-3 py-1 rounded-pill mb-1">☁️ Minimalist Urban Care</span>
                    <h2 class="fw-bold text-white mb-0"><?= htmlspecialchars($data['nama_usaha']); ?></h2>
                </div>
                <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-grey btn-sm mt-3 mt-md-0">
                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                </a>
            </div>

            <div class="mb-4">
                <h4 class="text-silver fw-bold mb-2"><?= htmlspecialchars($data['tagline']); ?></h4>
                
                <?php if (!empty($alamat_tampil)): ?>
                <p class="text-secondary small mb-3"><i class="bi bi-geo-alt-fill text-silver me-1"></i><strong>Alamat:</strong> <?= htmlspecialchars($alamat_tampil); ?></p>
                <?php endif; ?>

                <?php if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])): ?>
                    <img src="uploads/<?= $data['foto_produk']; ?>" class="rounded-4 img-fluid shadow mb-3" style="height: 220px; width: 100%; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                <?php else: ?>
                    <div class="rounded-4 bg-black py-4 border border-secondary border-opacity-25 text-secondary d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                        <i class="bi bi-image display-5 text-secondary opacity-50"></i>
                        <p class="mt-2 text-secondary small mb-0">[ Area Foto / Banner Usaha ]</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded-4 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                        <h6 class="text-silver fw-bold mb-2"><i class="bi bi-info-circle me-1"></i> Tentang Salon</h6>
                        <p class="text-secondary small mb-0"><?= nl2br(htmlspecialchars($data['bio'])); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                        <h6 class="text-silver fw-bold mb-2"><i class="bi bi-stars me-1"></i> Layanan Unggulan</h6>
                        <p class="text-white fw-semibold mb-0 small"><?= htmlspecialchars($data['produk_unggulan']); ?></p>
                    </div>
                </div>
            </div>

            <div class="text-center pt-3 border-top border-secondary border-opacity-25">
                <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-grey w-100">
                    <i class="bi bi-whatsapp me-2"></i> Reservasi Sesi Perawatan Sekarang
                </a>
            </div>
        </div>
    </div>
</body>
</html>