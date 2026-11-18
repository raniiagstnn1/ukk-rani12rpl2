<?php
/**
 * =================================================================
 * TAMBAH PORTFOLIO - LUXURY BLACK & GOLD EDITION
 * =================================================================
 */
session_start();
include 'koneksi.php';

// Proses simpan data saat form disubmit
if (isset($_POST['submit'])) {
    $id_admin       = 1; // Menggunakan ID admin pertama yang ada di tabel admins
    $nama_usaha     = mysqli_real_escape_string($koneksi, $_POST['nama_usaha']);
    $tagline        = mysqli_real_escape_string($koneksi, $_POST['tagline']);
    $bio            = mysqli_real_escape_string($koneksi, $_POST['bio']);
    $alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $produk_unggulan= mysqli_real_escape_string($koneksi, $_POST['produk_unggulan']);
    $no_wa          = mysqli_real_escape_string($koneksi, $_POST['no_wa']);
    $template       = mysqli_real_escape_string($koneksi, $_POST['template']);
    $status         = mysqli_real_escape_string($koneksi, $_POST['status']);
    
    // Generate slug otomatis dari nama usaha
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nama_usaha)));

    // Upload Logo Usaha (Opsional)
    $logo = 'default.png';
    if (!empty($_FILES['logo']['name'])) {
        $nama_file_logo = $_FILES['logo']['name'];
        $tmp_file_logo  = $_FILES['logo']['tmp_name'];
        $ekstensi_logo  = strtolower(pathinfo($nama_file_logo, PATHINFO_EXTENSION));
        $logo = 'logo_' . time() . '.' . $ekstensi_logo;
        move_uploaded_file($tmp_file_logo, 'uploads/' . $logo);
    }

    // Upload Foto Produk Utama (Opsional)
    $foto_produk = '';
    if (!empty($_FILES['foto_produk']['name'])) {
        $nama_file_fp = $_FILES['foto_produk']['name'];
        $tmp_file_fp  = $_FILES['foto_produk']['tmp_name'];
        $ekstensi_fp  = strtolower(pathinfo($nama_file_fp, PATHINFO_EXTENSION));
        $foto_produk = 'prod_' . time() . '.' . $ekstensi_fp;
        move_uploaded_file($tmp_file_fp, 'uploads/' . $foto_produk);
    }

    // Query Insert (Tanpa jam operasional)
    $query_insert = "INSERT INTO portfolios (id_admin, nama_usaha, slug, tagline, bio, alamat, produk_unggulan, no_wa, logo, foto_produk, template, status) 
                     VALUES ('$id_admin', '$nama_usaha', '$slug', '$tagline', '$bio', '$alamat', '$produk_unggulan', '$no_wa', '$logo', '$foto_produk', '$template', '$status')";
    
    if (mysqli_query($koneksi, $query_insert)) {
        $id_portfolio_baru = mysqli_insert_id($koneksi);

        // Handle upload Multi-Foto Galeri Tambahan
        if (!empty($_FILES['galeri_multi']['name'][0])) {
            foreach ($_FILES['galeri_multi']['tmp_name'] as $key => $tmp_name) {
                if (!empty($_FILES['galeri_multi']['name'][$key])) {
                    $nama_file_m = $_FILES['galeri_multi']['name'][$key];
                    $ekstensi_m  = strtolower(pathinfo($nama_file_m, PATHINFO_EXTENSION));
                    $nama_foto_m = 'galeri_' . time() . '_' . mt_rand(100, 999) . '.' . $ekstensi_m;
                    
                    if (move_uploaded_file($tmp_name, 'uploads/' . $nama_foto_m)) {
                        mysqli_query($koneksi, "INSERT INTO portfolio_images (portfolio_id, foto) VALUES ('$id_portfolio_baru', '$nama_foto_m')");
                    }
                }
            }
        }

        // Redirect langsung ke halaman web UMKM baru yang dibuat
        $file_template_tujuan = !empty($template) ? $template . '.php' : 'template1.php';
        echo "<script>alert('Portofolio UMKM berhasil ditambahkan!'); window.location='$file_template_tujuan?slug=$slug';</script>";
    } else {
        $error_msg = mysqli_error($koneksi);
        echo "<script>alert('Gagal menyimpan: $error_msg');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah UMKM Baru - Haute Couture Digital</title>
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
                <i class="bi bi-stars me-1"></i> Tambah Salon / UMKM Baru
            </span>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <h3 class="fw-bold font-serif text-white mb-2 text-center" style="font-size: 32px;">Form Input Portofolio Salon VIP</h3>
                    <p class="text-secondary small text-center mb-4">Tambahkan profil, layanan eksklusif, dan galeri salon klien.</p>
                    
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Nama Usaha / Salon</label>
                            <input type="text" name="nama_usaha" class="form-control" placeholder="Contoh: Lumière Haute Couture" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Tagline / Slogan</label>
                            <input type="text" name="tagline" class="form-control" placeholder="Contoh: The Pinnacle of Elite Beauty" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Tentang Usaha / Bio Singkat</label>
                            <textarea name="bio" class="form-control" rows="4" placeholder="Deskripsikan layanan atau keunggulan salon Anda..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Alamat Lengkap UMKM</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Contoh: Boulevard St. Honoré, Elite District"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Layanan Unggulan</label>
                            <input type="text" name="produk_unggulan" class="form-control" placeholder="Contoh: Royal Gold Facial, Diamond Hair Spa" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Nomor WhatsApp (Format: 628xxxxxxxxxx)</label>
                            <input type="text" name="no_wa" class="form-control" placeholder="6281234567890" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light fw-semibold small">Pilihan Template Web</label>
                                <select name="template" class="form-select" required>
                                    <option value="template1">Template 1 - Royal Emerald & Gold ($150)</option>
                                    <option value="template2">Template 2 - Platinum Midnight ($290)</option>
                                    <option value="template3">Template 3 - Obsidian Minimalist ($350)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light fw-semibold small">Status Publikasi</label>
                                <select name="status" class="form-select" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Logo Usaha (Opsional)</label>
                            <input type="file" name="logo" class="form-control">
                            <small class="text-secondary">Format gambar: JPG, PNG, atau WEBP.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold small">Foto Produk Utama / Banner (Opsional)</label>
                            <input type="file" name="foto_produk" class="form-control">
                            <small class="text-secondary">Format gambar: JPG, PNG, atau WEBP.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-light fw-semibold small">Galeri Foto Produk / Layanan Multi-File (Opsional)</label>
                            <input type="file" name="galeri_multi[]" class="form-control" multiple>
                            <small class="text-secondary">Bisa pilih banyak foto sekaligus untuk galeri katalog produk.</small>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" name="submit" class="btn btn-gold w-100 py-3 shadow">
                                <i class="bi bi-check-circle-fill me-2"></i> Simpan & Kunjungi Web UMKM
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>