<?php
/**
 * =================================================================
 * DASHBOARD ADMIN - BEAUTY DIGITAL HUB
 * Nuansa Ungu Mewah & Elegan (Selaras dengan Landing Page)
 * =================================================================
 */
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$query_portfolios = mysqli_query($koneksi, "SELECT * FROM portfolios ORDER BY id_portfolio DESC");
$total_umkm = mysqli_num_rows($query_portfolios);

$query_logs = mysqli_query($koneksi, "SELECT * FROM activity_logs ORDER BY id_log DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Beauty Digital Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0714;
            --bg-card: #130f24;
            --accent-purple-1: #7c3aed;
            --accent-purple-2: #a855f7;
            --text-bright: #ffffff;
            --text-soft: #cbd5e1;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #07050f 0%, #120b22 50%, #1a1033 100%);
            color: var(--text-bright);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: var(--bg-card);
            position: fixed;
            top: 0;
            left: 0;
            border-right: 1px solid rgba(139, 92, 246, 0.15);
            padding: 20px;
            z-index: 10;
        }
        .sidebar-brand {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }
        .nav-link {
            color: var(--text-soft);
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 13.5px;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link:hover, .nav-link.active {
            background: linear-gradient(135deg, var(--accent-purple-1), var(--accent-purple-2));
            color: #fff;
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.35);
        }

        /* Main Content */
        .main-content {
            margin-left: 240px;
            padding: 25px 35px;
        }

        /* Card Styling */
        .card-custom {
            background: var(--bg-card);
            border: 1px solid rgba(139, 92, 246, 0.15);
            border-radius: 22px;
            padding: 22px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        /* Tombol Tambah */
        .btn-add-umkm {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 22px;
            font-weight: 700;
            font-size: 13.5px;
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
            transition: 0.2s;
        }
        .btn-add-umkm:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: #fff;
        }

        /* Teks & Label Terang */
        .label-stat {
            color: #cbd5e1 !important;
            font-size: 12.5px;
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }
        .table {
            color: var(--text-bright);
            font-size: 13.5px;
        }
        .table > :not(caption) > * > * {
            background-color: transparent;
            color: var(--text-bright);
            border-bottom-color: rgba(139, 92, 246, 0.1);
            padding: 14px 10px;
        }
        .table thead th {
            color: #d8b4fe !important;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(139, 92, 246, 0.2);
        }

        /* Link Slug Styling */
        .slug-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(168, 85, 247, 0.15);
            color: #d8b4fe;
            border: 1px solid rgba(168, 85, 247, 0.35);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }
        .slug-link:hover {
            background: #a855f7;
            color: #ffffff;
        }

        /* Log Aktivitas */
        .log-container {
            max-height: 340px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .log-container::-webkit-scrollbar {
            width: 4px;
        }
        .log-container::-webkit-scrollbar-thumb {
            background: rgba(139, 92, 246, 0.25);
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar d-none d-lg-block">
        <div class="sidebar-brand">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow" style="width:36px;height:36px;background:linear-gradient(135deg, #7c3aed, #a855f7);">
                <i class="bi bi-stars"></i>
            </div>
            <span>BeautyDigital</span>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="dashboard.php"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php" target="_blank"><i class="bi bi-house-door"></i> Lihat Landing Page</a>
            </li>
            <li class="nav-item mt-5">
                <a class="nav-link text-danger bg-danger bg-opacity-10" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOPBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light border-opacity-10">
            <div>
                <h3 class="fw-bold mb-1 text-white">Dashboard Admin</h3>
                <p class="mb-0" style="color: #cbd5e1; font-size: 14px;">Kelola portofolio salon dan lihat aktivitas sistem secara real-time.</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="small" style="color: #cbd5e1;">Halo, <b class="text-white"><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?></b></span>
                <a href="tambah_portfolios.php" class="btn btn-add-umkm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah UMKM Baru
                </a>
            </div>
        </div>

        <!-- STATS KECIL DI ATAS -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card-custom d-flex align-items-center justify-content-between">
                    <div>
                        <span class="label-stat">Total UMKM Terdaftar</span>
                        <h4 class="fw-bold mb-0 text-white"><?= $total_umkm; ?> Salon</h4>
                    </div>
                    <div class="rounded-3 p-3" style="background:rgba(168,85,247,0.2); color:#d8b4fe; font-size:22px;">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-custom d-flex align-items-center justify-content-between">
                    <div>
                        <span class="label-stat">Status Server</span>
                        <h5 class="fw-bold mb-0 text-success"><i class="bi bi-circle-fill small me-1" style="font-size:10px;"></i> Aktif (Online)</h5>
                    </div>
                    <div class="rounded-3 p-3 text-success" style="background:rgba(25,135,84,0.2); font-size:22px;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-custom d-flex align-items-center justify-content-between">
                    <div>
                        <span class="label-stat">Developer UKK</span>
                        <h6 class="fw-bold mb-0 text-info">Rani Agustin (12 RPL)</h6>
                    </div>
                    <div class="rounded-3 p-3 text-info" style="background:rgba(13,202,240,0.2); font-size:22px;">
                        <i class="bi bi-code-slash"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KONTEN UTAMA: TABEL & LOG -->
        <div class="row g-4">
            <!-- TABEL -->
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-white mb-0"><i class="bi bi-folder2-open text-warning me-2"></i>Daftar Portofolio Salon Klien</h5>
                        <span class="badge bg-light bg-opacity-10 text-white"><?= $total_umkm; ?> Data</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Logo</th>
                                    <th>Nama Usaha</th>
                                    <th>Slug / Link Web</th>
                                    <th>Template</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                if (mysqli_num_rows($query_portfolios) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_portfolios)) { 
                                        $t_file = strtolower($row['template']) == 'template2' ? 'template2.php' : (strtolower($row['template']) == 'template3' ? 'template3.php' : 'template1.php');
                                        $url_web = $t_file . "?slug=" . urlencode($row['slug']);
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <?php if (!empty($row['logo']) && file_exists("uploads/" . $row['logo'])): ?>
                                            <img src="uploads/<?= $row['logo']; ?>" class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:11px;">No</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-white"><?= htmlspecialchars($row['nama_usaha']); ?></div>
                                        <div class="small" style="color: #cbd5e1;"><?= htmlspecialchars($row['tagline'] ?? ''); ?></div>
                                    </td>
                                    <!-- KOLOM SLUG YANG BISA DIKLIK -->
                                    <td>
                                        <a href="<?= $url_web; ?>" target="_blank" class="slug-link" title="Buka website <?= htmlspecialchars($row['nama_usaha']); ?>">
                                            <span>/<?= htmlspecialchars($row['slug']); ?></span>
                                            <i class="bi bi-box-arrow-up-right" style="font-size: 10px;"></i>
                                        </a>
                                    </td>
                                    <td><span class="badge bg-light bg-opacity-10 text-white"><?= htmlspecialchars($row['template']); ?></span></td>
                                    <td>
                                        <span class="badge <?= ($row['status'] == 'Aktif') ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?= htmlspecialchars($row['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= $url_web; ?>" target="_blank" class="btn btn-outline-success btn-sm px-2 py-1" title="Lihat Web"><i class="bi bi-globe"></i></a>
                                            <a href="edit_portfolio.php?id=<?= $row['id_portfolio']; ?>" class="btn btn-outline-warning btn-sm px-2 py-1" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                            <a href="hapus.php?id=<?= $row['id_portfolio']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');" class="btn btn-outline-danger btn-sm px-2 py-1" title="Hapus"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } } else { ?>
                                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data portofolio salon.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- LOG AKTIVITAS -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <h5 class="fw-bold text-white mb-3"><i class="bi bi-clock-history text-info me-2"></i>Log Aktivitas Sistem</h5>
                    <div class="log-container d-flex flex-column gap-3">
                        <?php if (mysqli_num_rows($query_logs) > 0) {
                            while ($log = mysqli_fetch_assoc($query_logs)) { ?>
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(139,92,246,0.15);">
                                <div class="fw-semibold text-white mb-1" style="font-size: 12.5px;"><?= htmlspecialchars($log['keterangan']); ?></div>
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 11px;">
                                    <span class="badge bg-primary bg-opacity-25 text-info"><?= htmlspecialchars($log['aksi'] ?? 'AKTIVITAS'); ?></span>
                                    <span style="color: #cbd5e1;"><?= $log['waktu']; ?></span>
                                </div>
                            </div>
                        <?php } } else { ?>
                            <p class="text-muted small text-center my-4">Belum ada aktivitas tercatat.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>