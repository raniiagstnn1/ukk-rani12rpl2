
<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM activity_logs ORDER BY id_log DESC");

if (!$query) {
    die("Gagal mengambil log aktivitas: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas - Haute Couture</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-card: #0d0d12;
            --text-soft: #94a3b8;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #12100e 0%, #060608 70%);
            color: white;
            min-height: 100vh;
        }

        .font-serif, .sidebar-brand, .page-title {
            font-family: 'Cormorant Garamond', serif;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: var(--bg-card);
            position: fixed;
            top: 0;
            left: 0;
            border-right: 1px solid rgba(212,175,55,0.2);
            padding: 20px;
            z-index: 10;
        }

        .sidebar-brand {
            font-size: 1.15rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .nav-link {
            color: var(--text-soft);
            border-radius: 12px;
            padding: 11px 14px;
            margin-bottom: 7px;
            font-weight: 600;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover, .nav-link.active {
            background: linear-gradient(135deg, #d4af37, #aa771c);
            color: #060608;
        }

        .main-content {
            margin-left: 240px;
            padding: 30px 35px;
        }

        .log-card {
            background: var(--bg-card);
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: white;
            --bs-table-border-color: rgba(255,255,255,0.08);
            vertical-align: middle;
            font-size: 13px;
        }

        .table thead th {
            color: #d4af37;
            font-weight: 600;
            white-space: nowrap;
        }

        .table td { padding: 15px 10px; }

        .action-badge {
            display: inline-block;
            background: rgba(212,175,55,0.12);
            color: #d4af37;
            border: 1px solid rgba(212,175,55,0.2);
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        @media(max-width: 991px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>

<body>

<div class="sidebar d-none d-lg-block">
    <div class="sidebar-brand">
        <div class="rounded-circle d-flex align-items-center justify-content-center text-dark"
             style="width:36px;height:36px;background:linear-gradient(135deg,#d4af37,#aa771c);">
            <i class="bi bi-stars"></i>
        </div>
        <span>Haute Couture</span>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="daftar_umkm.php">
                <i class="bi bi-shop"></i> Daftar UMKM Pelanggan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="log_aktivitas.php">
                <i class="bi bi-clock-history"></i> Log Aktivitas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php" target="_blank">
                <i class="bi bi-house-door"></i> Lihat Beranda
            </a>
        </li>
        <li class="nav-item mt-5">
            <a class="nav-link text-danger bg-danger bg-opacity-10" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light border-opacity-10 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1 page-title" style="font-size:30px;">Log Aktivitas</h3>
            <p class="mb-0 text-secondary small">Riwayat aktivitas yang terjadi pada data UMKM pelanggan.</p>
        </div>

        <div class="small text-secondary">
            Halo, <b class="text-white"><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?></b>
        </div>
    </div>

    <div class="log-card">
        <div class="mb-4">
            <h5 class="fw-bold mb-1">Riwayat Aktivitas</h5>
            <small class="text-secondary">Total <?= mysqli_num_rows($query); ?> aktivitas tercatat</small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Usaha</th>
                        <th>Aktivitas</th>
                        <th>Keterangan</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($row['nama_usaha'] ?? '-'); ?></td>
                                <td>
                                    <span class="action-badge">
                                        <?= htmlspecialchars($row['aksi'] ?? '-'); ?>
                                    </span>
                                </td>
                                <td class="text-secondary"><?= htmlspecialchars($row['keterangan'] ?? '-'); ?></td>
                                <td class="text-secondary text-nowrap">
                                    <?= !empty($row['waktu']) ? date('d M Y, H:i', strtotime($row['waktu'])) : '-'; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-5">
                                <i class="bi bi-clock-history fs-2 d-block mb-2"></i>
                                Belum ada aktivitas yang tercatat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
