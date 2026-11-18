<?php
/**
 * =================================================================
 * EDIT PORTFOLIO ADMIN - BEAUTY DIGITAL HUB
 * =================================================================
 */
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE id_portfolio = $id");
if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: dashboard.php");
    exit;
}
$data = mysqli_fetch_assoc($result);

$error = '';

if (isset($_POST['update'])) {
    $nama_usaha   = mysqli_real_escape_string($koneksi, $_POST['nama_usaha']);
    $tagline      = mysqli_real_escape_string($koneksi, $_POST['tagline']);
    $bio          = mysqli_real_escape_string($koneksi, $_POST['bio']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $produk       = mysqli_real_escape_string($koneksi, $_POST['produk_unggulan']);
    $no_wa        = mysqli_real_escape_string($koneksi, $_POST['no_wa']);
    $template     = mysqli_real_escape_string($koneksi, $_POST['template']);
    $status       = mysqli_real_escape_string($koneksi, $_POST['status']);

    // Upload Logo Baru (Jika ada)
    $logo = $data['logo'];
    if (!empty($_FILES['logo']['name'])) {
        $nama_file_logo = $_FILES['logo']['name'];
        $tmp_logo       = $_FILES['logo']['tmp_name'];
        $ekstensi_logo  = pathinfo($nama_file_logo, PATHINFO_EXTENSION);
        $logo           = 'logo_' . time() . '.' . $ekstensi_logo;
        move_uploaded_file($tmp_logo, 'uploads/' . $logo);
        
        // Hapus logo lama jika bukan default
        if ($data['logo'] != 'default.png' && file_exists("uploads/" . $data['logo'])) {
            unlink("uploads/" . $data['logo']);
        }
    }

    // Upload Foto Produk Baru (Jika ada)
    $foto_produk = $data['foto_produk'];
    if (!empty($_FILES['foto_produk']['name'])) {
        $nama_file_foto = $_FILES['foto_produk']['name'];
        $tmp_foto       = $_FILES['foto_produk']['tmp_name'];
        $ekstensi_foto  = pathinfo($nama_file_foto, PATHINFO_EXTENSION);
        $foto_produk    = 'produk_' . time() . '.' . $ekstensi_foto;
        move_uploaded_file($tmp_foto, 'uploads/' . $foto_produk);
        
        // Hapus foto lama jika ada
        if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])) {
            unlink("uploads/" . $data['foto_produk']);
        }
    }

    // Update Database (Trigger MySQL akan otomatis mencatat log aktivitas UBAH DATA)
    $query = "UPDATE portfolios SET 
                nama_usaha = '$nama_usaha', 
                tagline = '$tagline', 
                bio = '$bio', 
                alamat = '$alamat', 
                produk_unggulan = '$produk', 
                no_wa = '$no_wa', 
                template = '$template', 
                logo = '$logo', 
                foto_produk = '$foto_produk', 
                status = '$status' 
              WHERE id_portfolio = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit UMKM - Beauty Digital Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #07050f 0%, #120b22 50%, #1a1033 100%);
            color: #ffffff;
            min-height: 100vh;
            padding: 40px 0;
        }
        .form-card {
            background: #130f24;
            border: 1px solid rgba(139, 92, 246, 0.2);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            max-width: 750px;
            margin: 0 auto;
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(139, 92, 246, 0.25);
            color: #fff;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #a855f7;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.2);
        }
        .form-label {
            font-weight: 600;
            font-size: 13.5px;
            color: #d8b4fe;
            margin-bottom: 6px;
        }
        .btn-submit {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
        }
        .btn-submit:hover { opacity: 0.9; color: #fff; }
        .btn-batal {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #cbd5e1;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
        }
        .btn-batal:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light border-opacity-10">
                <div>
                    <h3 class="fw-bold mb-1 text-white"><i class="bi bi-pencil-square me-2"></i>Edit UMKM Salon</h3>
                    <p class="text-secondary small mb-0">Perbarui informasi portofolio dan alamat salon klien.</p>
                </div>
                <a href="dashboard.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger rounded-4 py-2 small"><?= $error; ?></div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nama Usaha / Salon</label>
                    <input type="text" name="nama_usaha" class="form-control" value="<?= htmlspecialchars($data['nama_usaha']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tagline / Slogan Singkat</label>
                    <input type="text" name="tagline" class="form-control" value="<?= htmlspecialchars($data['tagline']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tentang Usaha / Bio Singkat</label>
                    <textarea name="bio" class="form-control" rows="3" required><?= htmlspecialchars($data['bio']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap Salon</label>
                    <textarea name="alamat" class="form-control" rows="2" required><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Layanan Unggulan</label>
                    <input type="text" name="produk_unggulan" class="form-control" value="<?= htmlspecialchars($data['produk_unggulan']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp (Format: 628xxxxxxxxxx)</label>
                    <input type="text" name="no_wa" class="form-control" value="<?= htmlspecialchars($data['no_wa']); ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilihan Template Web</label>
                        <select name="template" class="form-select">
                            <option value="template1" <?= ($data['template'] == 'template1') ? 'selected' : ''; ?>>Template 1 - Luxury Maroon</option>
                            <option value="template2" <?= ($data['template'] == 'template2') ? 'selected' : ''; ?>>Template 2 - Soft Pink</option>
                            <option value="template3" <?= ($data['template'] == 'template3') ? 'selected' : ''; ?>>Template 3 - Urban Grey</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Publikasi</label>
                        <select name="status" class="form-select">
                            <option value="Aktif" <?= ($data['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Draft" <?= ($data['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo Usaha (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Foto Produk / Banner (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="foto_produk" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top border-light border-opacity-10">
                    <a href="dashboard.php" class="btn btn-batal">Batal</a>
                    <button type="submit" name="update" class="btn btn-submit">
                        <i class="bi bi-save me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>