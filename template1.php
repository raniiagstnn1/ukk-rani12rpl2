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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama_usaha']); ?> - Luxury Edition</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #06110e; color: #e2e8f0; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .navbar-custom { background: rgba(6, 17, 14, 0.95); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(212, 175, 55, 0.3); }
        .hero-section { padding: 80px 0; background: radial-gradient(circle at top right, #0f2b22 0%, #06110e 70%); }
        .btn-gold { background: linear-gradient(135deg, #d4af37 0%, #aa771c 100%); color: #06110e; font-weight: 700; border-radius: 50px; padding: 14px 36px; border: none; box-shadow: 0 10px 30px rgba(212,175,55,0.3); transition: 0.3s; }
        .btn-gold:hover { background: linear-gradient(135deg, #e5c158 0%, #c48b22 100%); color: #06110e; transform: translateY(-2px); }
        .card-custom { background: #0a1f19; border: 1px solid rgba(212, 175, 55, 0.25); border-radius: 20px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        .contact-box { background: rgba(212, 175, 55, 0.05); border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 16px; padding: 20px; margin-top: 25px; }
        .text-gold { color: #d4af37 !important; }
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-top: 15px; }
        .portfolio-card-item { background: #0a1f19; border: 1px solid rgba(212,175,55,0.25); border-radius: 16px; overflow: hidden; padding: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.4); transition: transform 0.3s ease; }
        .portfolio-card-item:hover { transform: translateY(-5px); }
        .portfolio-img-box { width: 100%; height: 210px; border-radius: 12px; overflow: hidden; background: #0f2b22; display: flex; align-items: center; justify-content: center; }
        .portfolio-img-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; transition: transform 0.5s ease; }
        .portfolio-card-item:hover .portfolio-img-box img { transform: scale(1.08); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-3 border-secondary text-light"><i class="bi bi-arrow-left me-1"></i> Home</a>
            <span class="navbar-brand fw-bold fs-4 font-serif text-gold mb-0"><?= htmlspecialchars($data['nama_usaha']); ?></span>
            <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-gold btn-sm"><i class="bi bi-whatsapp me-1"></i> Concierge</a>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-gold bg-opacity-10 text-gold px-3 py-2 rounded-pill mb-3 font-serif border border-gold border-opacity-25" style="letter-spacing: 2px;">✨ ELITE LUXURY EXPERIENCE</span>
                    <h1 class="display-4 fw-bold font-serif mb-4 text-white" style="line-height: 1.15;"><?= htmlspecialchars($data['tagline']); ?></h1>
                    <p class="text-secondary fs-6 mb-4" style="font-weight: 300; line-height: 1.8;"><?= nl2br(htmlspecialchars($data['bio'])); ?></p>
                    
                    <?php if (!empty($alamat_tampil)): ?>
                    <div class="contact-box">
                        <div class="d-flex align-items-start gap-3 text-white">
                            <i class="bi bi-geo-alt-fill text-gold fs-4 mt-1"></i>
                            <div>
                                <strong class="small d-block text-gold font-serif fs-6">Exclusive Location :</strong>
                                <span class="text-secondary small"><?= htmlspecialchars($alamat_tampil); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="<?= $link_wa; ?>" target="_blank" class="btn btn-gold btn-lg w-100 py-3 shadow">
                            <i class="bi bi-calendar-check me-2"></i> Book Private Appointment
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <h5 class="text-gold font-serif mb-3 fs-4">✦ Signature Treatments & Gallery</h5>
                    <div class="gallery-grid">
                        <?php 
                        $ada_foto = false;
                        if (!$is_demo && $id_port > 0) {
                            $query_img = mysqli_query($koneksi, "SELECT * FROM portfolio_images WHERE portfolio_id = '$id_port'");
                            if ($query_img && mysqli_num_rows($query_img) > 0) {
                                $ada_foto = true;
                                while($img = mysqli_fetch_assoc($query_img)) {
                                    echo '<div class="portfolio-card-item"><div class="portfolio-img-box"><img src="uploads/'.$img['foto'].'" alt="Luxury Portfolio"></div></div>';
                                }
                            }
                        }
                        if (!$ada_foto) {
                            if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])) {
                                echo '<div class="portfolio-card-item"><div class="portfolio-img-box"><img src="uploads/'.$data['foto_produk'].'" alt="Main Product"></div></div>';
                            } else {
                                echo '<div class="w-100 rounded-4 bg-black py-4 border border-gold border-opacity-25 text-secondary text-center d-flex flex-column align-items-center justify-content-center" style="height: 210px; grid-column: span 2;">
                                        <i class="bi bi-gem display-4 text-gold opacity-50"></i>
                                        <p class="mt-2 text-secondary small font-serif">[ Private Showcase Preview ]</p>
                                      </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-4">
        <div class="card-custom text-center py-5">
            <h3 class="font-serif text-gold mb-3 fs-2">Signature Core Services</h3>
            <p class="fs-5 text-white font-serif tracking-wide mb-0"><?= htmlspecialchars($data['produk_unggulan']); ?></p>
        </div>
    </main>

    <footer class="text-center py-4 text-secondary border-top border-dark mt-5" style="border-color: rgba(212,175,55,0.1) !important;">
        <p class="small mb-0 font-serif">&copy; 2026 <?= htmlspecialchars($data['nama_usaha']); ?> &bull; Haute Couture Digital Experience</p>
    </footer>
</body>
</html>