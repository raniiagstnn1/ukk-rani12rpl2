<?php
/**
 * =================================================================
 * EDIT PORTFOLIO - LUXURY BLACK & GOLD EDITION
 * =================================================================
 */
session_start();
include 'koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data portofolio berdasarkan ID
$query_old = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE id_portfolio = $id");
$data = mysqli_fetch_assoc($query_old);

if (!$data) {
    echo "<script>alert('Data portofolio tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit;
}

// Proses update saat form disubmit
if (isset($_POST['update'])) {
    $id_admin       = 1; // Memastikan id_admin tetap terisi sesuai struktur tabel database
    $nama_usaha     = mysqli_real_escape_string($koneksi, $_POST['nama_usaha']);
    $tagline        = mysqli_real_escape_string($koneksi, $_POST['tagline']);
    $bio            = mysqli_real_escape_string($koneksi, $_POST['bio']);
    $alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $produk_unggulan= mysqli_real_escape_string($koneksi, $_POST['produk_unggulan']);
    $no_wa          = mysqli_real_escape_string($koneksi, $_POST['no_wa']);
    $template       = mysqli_real_escape_string($koneksi, $_POST['template']);
    $status         = mysqli_real_escape_string($koneksi, $_POST['status']);
    
    // Generate slug baru
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nama_usaha)));

    // Update Logo jika diupload baru
    $logo_query_part = "";
    if (!empty($_FILES['logo']['name'])) {
        $nama_file_logo = $_FILES['logo']['name'];
        $tmp_file_logo  = $_FILES['logo']['tmp_name'];
        $ekstensi_logo  = strtolower(pathinfo($nama_file_logo, PATHINFO_EXTENSION));
        $logo = 'logo_' . time() . '.' . $ekstensi_logo;
        
        if (move_uploaded_file($tmp_file_logo, 'uploads/' . $logo)) {
            if (!empty($data['logo']) && $data['logo'] != 'default.png' && file_exists("uploads/" . $data['logo'])) {
                unlink("uploads/" . $data['logo']);
            }
            $logo_query_part = ", logo = '$logo'";
        }
    }

    // Update Foto Produk Utama jika diupload baru
    $foto_produk_query_part = "";
    if (!empty($_FILES['foto_produk']['name'])) {
        $nama_file_fp = $_FILES['foto_produk']['name'];
        $tmp_file_fp  = $_FILES['foto_produk']['tmp_name'];
        $ekstensi_fp  = strtolower(pathinfo($nama_file_fp, PATHINFO_EXTENSION));
        $foto_produk = 'prod_' . time() . '.' . $ekstensi_fp;
        
        if (move_uploaded_file($tmp_file_fp, 'uploads/' . $foto_produk)) {
            if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])) {
                unlink("uploads/" . $data['foto_produk']);
            }
            $foto_produk_query_part = ", foto_produk = '$foto_produk'";
        }
    }

    // Query Update Data Utama
    $query_update = "UPDATE portfolios SET 
                        id_admin = '$id_admin',
                        nama_usaha = '$nama_usaha',
                        slug = '$slug',
                        tagline = '$tagline',
                        bio = '$bio',
                        alamat = '$alamat',
                        produk_unggulan = '$produk_unggulan',
                        no_wa = '$no_wa',
                        template = '$template',
                        status = '$status'
                        $logo_query_part
                        $foto_produk_query_part
                     WHERE id_portfolio = $id";

    if (mysqli_query($koneksi, $query_update)) {
        // Handle upload Multi-Foto Galeri Tambahan (Jika ada yang baru)
        if (!empty($_FILES['galeri_multi']['name'][0])) {
            foreach ($_FILES['galeri_multi']['tmp_name'] as $key => $tmp_name) {
                if (!empty($_FILES['galeri_multi']['name'][$key])) {
                    $nama_file_m = $_FILES['galeri_multi']['name'][$key];
                    $ekstensi_m  = strtolower(pathinfo($nama_file_m, PATHINFO_EXTENSION));
                    $nama_foto_m = 'galeri_' . time() . '_' . mt_rand(100, 999) . '.' . $ekstensi_m;
                    
                    if (move_uploaded_file($tmp_name, 'uploads/' . $nama_foto_m)) {
                        mysqli_query($koneksi, "INSERT INTO portfolio_images (portfolio_id, foto) VALUES ('$id', '$nama_foto_m')");
                    }
                }
            }
        }

        // Tentukan file template tujuan dan langsung arahkan ke halaman web UMKM tersebut
        $file_template_tujuan = !empty($template) ? $template . '.php' : 'template1.php';

        echo "<script>alert('Portofolio UMKM berhasil diperbarui!'); window.location='$file_template_tujuan?slug=$slug';</script>";
    } else {
        $error_msg = mysqli_error($koneksi);
        echo "<script>alert('Gagal memperbarui: $error_msg');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit UMKM - Haute Couture Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(circle at top right, #12100e 0%, #060608 70%);
            color: #f8fafc; 
            min-height: 100vh;
        }
        .font-serif { 
            font-family: 'Cormorant Garamond', serif; 
        }
        .navbar-custom { 
            background: rgba(13, 13, 18, 0.95); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid rgba(212, 175, 55, 0.25); 
        }
        .form-card { 
            background: #0d0d12; 
            border: 1px solid rgba(212, 175, 55, 0.25); 
            border-radius: 22px; 
            padding: 40px; 
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.7); 
        }
        .btn-gold { 
            background: linear-gradient(135deg, #d4af37 0%, #aa771c 100%); 
            color: #060608; 
            font-weight: 700; 
            border-radius: 50px; 
            padding: 14px 30px; 
            border: none; 
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3); 
            transition: 0.3s; 
        }
        .btn-gold:hover { 
            background: linear-gradient(135deg, #e5c158 0%, #c48b22 100%); 
            color: #060608; 
            transform: translateY(-2px); 
            box-shadow: 0 14px 30px rgba(212, 175, 55, 0.45); 
        }
        .text-gold-accent { 
            color: #f3e5ab !important; 
        }
        .form-control, .form-select { 
            background-color: #060608 !important; 
            border: 1px solid rgba(212, 175, 55, 0.3) !important; 
            color: #f8fafc !important; 
            border-radius: 12px; 
            padding: 12px 15px; 
        }
        .form-control:focus, .form-select:focus { 
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25); 
            border-color: #d4af37 !important; 
            background-color: #0d0d12 !important; 
            color: #fff !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm rounded-pill px-3 border-secondary text-light">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <span class="navbar-brand fw-bold fs-5 text-gold-accent font-serif mb-0" style="letter-spacing: 0.5px;">
                <i class="bi bi-stars me-1"></i> Edit Portofolio Salon
            </span>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <h3 class="fw-bold font-serif text-white mb-2 text-center" style="font-size: 32px;">Form Edit Portofolio Salon VIP</h3>
                    <p class="text-secondary small text-center mb-4">Perbarui informasi profil dan layanan salon klien.</p>
                    
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Nama Usaha / Salon</label>
                            <input type="text" name="nama_usaha" class="form-control" value="<?= htmlspecialchars($data['nama_usaha']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Tagline / Slogan</label>
                            <input type="text" name="tagline" class="form-control" value="<?= htmlspecialchars($data['tagline']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Tentang Usaha / Bio Singkat</label>
                            <textarea name="bio" class="form-control" rows="4" required><?= htmlspecialchars($data['bio']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Alamat Lengkap UMKM</label>
                            <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Layanan Unggulan</label>
                            <input type="text" name="produk_unggulan" class="form-control" value="<?= htmlspecialchars($data['produk_unggulan']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Nomor WhatsApp (Format: 628xxxxxxxxxx)</label>
                            <input type="text" name="no_wa" class="form-control" value="<?= htmlspecialchars($data['no_wa']); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light fw-semibold small">Pilihan Template Web</label>
                                <select name="template" class="form-select" required>
                                    <option value="template1" <?= ($data['template'] == 'template1') ? 'selected' : ''; ?>>Template 1 - Royal Emerald & Gold ($150)</option>
                                    <option value="template2" <?= ($data['template'] == 'template2') ? 'selected' : ''; ?>>Template 2 - Platinum Midnight ($290)</option>
                                    <option value="template3" <?= ($data['template'] == 'template3') ? 'selected' : ''; ?>>Template 3 - Obsidian Minimalist ($350)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light fw-semibold small">Status Publikasi</label>
                                <select name="status" class="form-select" required>
                                    <option value="Aktif" <?= ($data['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="Draft" <?= ($data['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                                </select>
                            </div>
                        </div>

                        <!-- LOGO USAHA DENGAN TOMBOL HAPUS -->
                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Logo Usaha Saat Ini</label>
                            <div class="mb-2 d-flex align-items-center gap-3">
                                <?php if (!empty($data['logo']) && file_exists("uploads/" . $data['logo'])): ?>
                                    <img src="uploads/<?= $data['logo']; ?>" alt="Logo" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(212,175,55,0.3);">
                                    <a href="hapus_foto.php?id=<?= $id; ?>&jenis=logo" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus logo ini?');">
                                        <i class="bi bi-trash me-1"></i> Hapus Logo
                                    </a>
                                <?php else: ?>
                                    <span class="text-secondary small">[Belum ada logo]</span>
                                <?php endif; ?>
                            </div>
                            <label class="form-label text-light fw-semibold small">Ganti Logo Baru (Opsional)</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <!-- FOTO PRODUK / BANNER UTAMA DENGAN TOMBOL HAPUS -->
                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Foto Produk Utama / Banner Saat Ini</label>
                            <div class="mb-2 d-flex align-items-center gap-3">
                                <?php if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])): ?>
                                    <img src="uploads/<?= $data['foto_produk']; ?>" alt="Banner" style="width: 100px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(212,175,55,0.3);">
                                    <a href="hapus_foto.php?id=<?= $id; ?>&jenis=foto_produk" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus foto produk ini?');">
                                        <i class="bi bi-trash me-1"></i> Hapus Foto Produk
                                    </a>
                                <?php else: ?>
                                    <span class="text-secondary small">[Belum ada foto produk]</span>
                                <?php endif; ?>
                            </div>
                            <label class="form-label text-light fw-semibold small">Ganti Foto Produk / Banner Baru (Opsional)</label>
                            <input type="file" name="foto_produk" class="form-control">
                        </div>

                        <!-- KELOLA & HAPUS FOTO GALERI TAMBAHAN SATU-SATU -->
                        <div class="mb-4">
                            <label class="form-label text-light fw-semibold small">Kelola Foto Galeri Saat Ini (Hapus Satuan)</label>
                            <div class="row g-3 mb-3">
                                <?php
                                $query_cek_galeri = mysqli_query($koneksi, "SELECT * FROM portfolio_images WHERE portfolio_id = $id");
                                if ($query_cek_galeri && mysqli_num_rows($query_cek_galeri) > 0) {
                                    while ($gal = mysqli_fetch_assoc($query_cek_galeri)) {
                                ?>
                                    <div class="col-md-3 text-center">
                                        <div class="p-2 rounded-3" style="background: #060608; border: 1px solid rgba(212,175,55,0.2);">
                                            <img src="uploads/<?= htmlspecialchars($gal['foto']); ?>" style="width: 100%; height: 90px; object-fit: cover; border-radius: 8px;" class="mb-2">
                                            <a href="hapus_galeri.php?id=<?= $gal['id']; ?>&portfolio_id=<?= $id; ?>" class="btn btn-outline-danger btn-sm w-100 py-1" style="font-size: 11.5px;" onclick="return confirm('Yakin ingin menghapus foto galeri ini?');">
                                                <i class="bi bi-trash me-1"></i> Hapus Foto
                                            </a>
                                        </div>
                                    </div>
                                <?php 
                                    }
                                } else {
                                    echo '<div class="col-12"><span class="text-secondary small">[Belum ada foto galeri tambahan]</span></div>';
                                }
                                ?>
                            </div>
                            
                            <label class="form-label text-light fw-semibold small">Tambah Galeri Foto Multi-File Baru (Opsional)</label>
                            <input type="file" name="galeri_multi[]" class="form-control" multiple>
                            <small class="text-secondary">Foto baru akan ditambahkan ke galeri katalog yang sudah ada.</small>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" name="update" class="btn btn-gold w-100 py-3 shadow">
                                <i class="bi bi-arrow-repeat me-2"></i> Perbarui & Kunjungi Web UMKM
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>