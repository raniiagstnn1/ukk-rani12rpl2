<?php
/**
 * =================================================================
 * PROYEK UKK RPL - BEAUTY DIGITAL HUB
 * Halaman Kelola Data UMKM / Portofolio - Tema Pastel Cream Luxury
 * Pengembang: Rani Agustin (12 RPL)
 * =================================================================
 */
session_start();
include 'koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit;
}

// Ambil semua data portofolio UMKM dari database
$query = mysqli_query($koneksi, "SELECT * FROM portfolios ORDER BY id_portfolio DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data UMKM - Beauty Digital Hub</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream-bg: #FDFBF7;
            --mocha-dark: #4A3B32;
            --mocha-primary: #6D4C41;
            --mocha-light: #EFEBE9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--cream-bg);
            color: var(--mocha-dark);
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #4A3B32 0%, #3E2723 100%);
            color: #FFFFFF;
            padding: 1.5rem 1rem;
            z-index: 100;
        }

        .sidebar-brand {
            font-size: 1.2rem;
            font-weight: 700;
            color: #FFFFFF;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin-top: 1.5rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #D7CCC8;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(109, 76, 65, 0.4);
            color: #FFFFFF;
        }

        .main-content {
            margin-left: 260px;
            padding: 2.5rem;
        }

        .content-card {
            background: #FFFFFF;
            border-radius: 20px;
            padding: 2.5rem;
            border: 1px solid var(--mocha-light);
            box-shadow: 0 10px 30px rgba(141, 109, 98, 0.05);
        }

        .btn-luxury {
            background: linear-gradient(135deg, #6D4C41 0%, #4E342E 100%);
            color: #FFFFFF;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(109, 76, 65, 0.2);
            transition: all 0.2s;
        }

        .btn-luxury:hover {
            background: linear-gradient(135deg, #5D4037 0%, #3E2723 100%);
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .table-custom th {
            background-color: #F5ECE5;
            color: #4A3B32;
            font-weight: 700;
            border-bottom: 2px solid #D7CCC8;
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            vertical-align: middle;
            color: #5D4037;
        }

        .badge-template {
            background: #EFEBE9;
            color: #5D4037;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid #D7CCC8;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="dashboard.php" class="sidebar-brand">
            <i class="bi bi-stars fs-4 text-warning"></i>
            <span>Beauty Digital Hub</span>
        </a>
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="portfolios.php" class="active">
                    <i class="bi bi-collection-fill"></i> Kelola Data UMKM
                </a>
            </li>
            <li>
                <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #4A3B32;">Manajemen Data UMKM Salon</h4>
                    <p class="text-muted small mb-0">Daftar seluruh website salon mitra yang terdaftar dalam sistem</p>
                </div>
                <a href="tambah_portfolios.php" class="btn btn-luxury">
                    <i class="bi bi-plus-circle me-2"></i> Tambah UMKM Baru
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">Logo</th>
                            <th style="width: 25%;">Nama Usaha & Slogan</th>
                            <th style="width: 18%;">No. WhatsApp</th>
                            <th style="width: 15%;">Template</th>
                            <th class="text-center" style="width: 25%;">Aksi Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($query) > 0) : ?>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $no++; ?></td>
                                    <td>
                                        <?php if (!empty($row['logo']) && file_exists("uploads/" . $row['logo'])) : ?>
                                            <img src="uploads/<?= $row['logo']; ?>" width="45" height="45" class="rounded-circle object-fit-cover border shadow-sm" alt="Logo">
                                        <?php else : ?>
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm" style="width:45px;height:45px;font-size:10px;">No Logo</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama_usaha']); ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($row['tagline']); ?></small>
                                    </td>
                                    <td>
                                        <span class="small"><i class="bi bi-whatsapp text-success me-1"></i><?= htmlspecialchars($row['no_wa']); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge-template">
                                            <i class="bi bi-palette me-1"></i> <?= ucfirst($row['template']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="salon.php?slug=<?= $row['slug']; ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-semibold" title="Lihat Website">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                            <a href="edit.php?id=<?= $row['id_portfolio']; ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id_portfolio']; ?>" onclick="return confirm('Yakin ingin menghapus data UMKM ini?')" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold" title="Hapus Data">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data UMKM salon yang terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>