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
        'template' => 'template2'
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
$link_wa = "https://wa.me/" . preg_replace('/[^0-9]/', '', $data['no_wa']) . "?text=Halo%20" . urlencode($data['nama_usaha']) . ",%20saya%20ingin%20booking.";
$alamat_tampil = !empty($data['alamat']) ? $data['alamat'] : (!$is_demo ? 'Alamat belum diatur' : '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama_usaha']); ?> - Soft Pink Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Space Grotesk', sans-serif; background-color: #0d0a0c; color: #fff; min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between; }
        .text-softpink { color: #ff8fab; }
        .top-bar { background: rgba(13, 10, 12, 0.9); border-bottom: 1px solid rgba(255,143,171,0.15); backdrop-filter: blur(10px); }
        .btn-softpink { background: linear-gradient(135deg, #ff8fab, #fb6f92); color: #fff; font-weight: 800; border-radius: 50px; padding: 12px 28px; border: none; box-shadow: 0 10px 25px rgba(255,143,171,0.3); transition: 0.3s; }
        .btn-softpink:hover { opacity: 0.9; transform: translateY(-2px); color: #fff; }
        .profile-card { background: #181215; border: 1.5px solid rgba(255,143,171,0.25); border-radius: 28px; padding: 35px; height: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.6); }
        .content-card { background: #181215; border: 1.5px solid rgba(255,143,171,0.2); border-radius: 28px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.6); }
    </style>
</head>
<body>

    <div class="top-bar py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
            <span class="fw-bold text-softpink small"><i class="bi bi-heart-fill me-1"></i> Soft Pink Studio Layout</span>
        </div>
    </div>

    <main class="container py-5">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="profile-card d-flex flex-column justify-content-between text-center text-lg-start">
                    <div>
                        <span class="badge px-3 py-2 rounded-pill mb-3 fw-bold" style="background:rgba(255,143,171,0.15); color:#ff8fab;">🌸 Soft Pastel Beauty</span>
                        <h1 class="fw-black text-white mb-2" style="font-weight: 900; font-size: 2rem;"><?= htmlspecialchars($data['nama_usaha']); ?></h1>
                        <p class="text-softpink fw-semibold fs-6 mb-3"><?= htmlspecialchars($data['tagline']); ?></p>
                        
                        <?php if (!empty($alamat_tampil)): ?>
                        <div class="p-3 rounded-4 mb-3 text-start" style="background: rgba(255,143,171,0.06); border: 1px solid rgba(255,143,171,0.2);">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-geo-alt-fill text-softpink mt-1"></i>
                                <div>
                                    <span class="small fw-bold d-block text-softpink">Alamat :</span>
                                    <span class="text-secondary small"><?= htmlspecialchars($alamat_tampil); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <?php if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])): ?>
                                <img src="uploads/<?= $data['foto_produk']; ?>" class="rounded-4 img-fluid shadow" style="height: 160px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-4 bg-black py-3 border border-secondary border-opacity-25 text-secondary d-flex flex-column align-items-center justify-content-center" style="height: 140px;">
                                    <i class="bi bi-image fs-3 text-softpink opacity-50"></i>
                                    <p class="mt-1 text-secondary small mb-0">[ Area Foto / Banner Usaha ]</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-softpink w-100 py-3 mb-2">
                            <i class="bi bi-whatsapp me-2"></i> Booking via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 d-flex flex-column gap-4">
                <div class="content-card flex-grow-1">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="rounded-3 p-2 text-softpink fs-5" style="background: rgba(255,143,171,0.1);">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-0">Tentang Studio</h4>
                    </div>
                    <p class="text-secondary fs-6 mb-0"><?= nl2br(htmlspecialchars($data['bio'])); ?></p>
                </div>

                <div class="content-card flex-grow-1">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="rounded-3 p-2 text-softpink fs-5" style="background: rgba(255,143,171,0.1);">
                            <i class="bi bi-stars"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-0">Layanan & Produk Unggulan</h4>
                    </div>
                    <p class="text-softpink fw-bold fs-5 mb-0"><?= htmlspecialchars($data['produk_unggulan']); ?></p>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-4 text-secondary border-top border-dark mt-auto">
        <p class="small mb-0">&copy; 2026 <?= htmlspecialchars($data['nama_usaha']); ?> &bull; Beauty Digital Hub</p>
    </footer>

</body>
</html>