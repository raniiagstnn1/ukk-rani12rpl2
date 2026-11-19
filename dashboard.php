
<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$query_total = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM portfolios");
$data_total = mysqli_fetch_assoc($query_total);
$total_umkm = $data_total['total'] ?? 0;

$query_aktif = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM portfolios WHERE status='Aktif'");
$data_aktif = mysqli_fetch_assoc($query_aktif);
$total_aktif = $data_aktif['total'] ?? 0;

$query_draft = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM portfolios WHERE status='Draft'");
$data_draft = mysqli_fetch_assoc($query_draft);
$total_draft = $data_draft['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Haute Couture</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #060608;
            --bg-card: #0d0d12;
            --gold-primary: #d4af37;
            --gold-light: #f3e5ab;
            --gold-dark: #aa771c;
            --text-bright: #ffffff;
            --text-soft: #94a3b8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #12100e 0%, #060608 70%);
            color: var(--text-bright);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .font-serif {
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
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            font-family: 'Cormorant Garamond', serif;
        }

        .nav-link {
            color: var(--text-soft);
            border-radius: 12px;
            padding: 11px 14px;
            margin-bottom: 7px;
            font-weight: 600;
            font-size: 13.5px;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, #d4af37, #aa771c);
            color: #060608;
            box-shadow: 0 5px 15px rgba(212,175,55,0.3);
        }

        .main-content {
            margin-left: 240px;
            padding: 30px 35px;
        }

        .card-custom {
            background: var(--bg-card);
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: 22px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            min-height: 145px;
        }

        .label-stat {
            color: #94a3b8;
            font-size: 12.5px;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }

        .stat-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 34px;
            font-weight: 700;
            margin: 0;
        }

        .gold-icon {
            background: linear-gradient(135deg, #d4af37, #aa771c);
            color: #060608;
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .green-icon {
            background: rgba(25,135,84,0.15);
            color: #16a36a;
            border: 1px solid rgba(25,135,84,0.3);
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .draft-icon {
            background: rgba(148,163,184,0.12);
            color: #94a3b8;
            border: 1px solid rgba(148,163,184,0.3);
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        @media(max-width: 991px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }
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
            <a class="nav-link active" href="dashboard.php">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="daftar_umkm.php">
                <i class="bi bi-shop"></i>
                Daftar UMKM Pelanggan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="log_aktivitas.php">
                <i class="bi bi-clock-history"></i>
                Log Aktivitas
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.php" target="_blank">
                <i class="bi bi-house-door"></i>
                Lihat Beranda
            </a>
        </li>

        <li class="nav-item mt-5">
            <a class="nav-link text-danger bg-danger bg-opacity-10" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </li>

    </ul>
</div>

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom border-light border-opacity-10 flex-wrap gap-3">

        <div>
            <h3 class="fw-bold mb-1 text-white font-serif" style="font-size:30px;">
                Admin Dashboard
            </h3>

            <p class="mb-0 text-secondary" style="font-size:14px;">
                Selamat datang di panel admin Haute Couture Digital.
            </p>
        </div>

        <div class="small text-secondary">
            Halo,
            <b class="text-white">
                <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?>
            </b>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-6 col-xl-4">
            <div class="card-custom d-flex align-items-center justify-content-between">

                <div>
                    <span class="label-stat">Total UMKM Terdaftar</span>
                    <h4 class="stat-number text-white">
                        <?= $total_umkm; ?>
                    </h4>
                    <small class="text-secondary">Seluruh pelanggan</small>
                </div>

                <div class="gold-icon">
                    <i class="bi bi-shop"></i>
                </div>

            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card-custom d-flex align-items-center justify-content-between">

                <div>
                    <span class="label-stat">Website Aktif</span>
                    <h4 class="stat-number text-success">
                        <?= $total_aktif; ?>
                    </h4>
                    <small class="text-secondary">Status Aktif</small>
                </div>

                <div class="green-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card-custom d-flex align-items-center justify-content-between">

                <div>
                    <span class="label-stat">Website Draft</span>
                    <h4 class="stat-number text-secondary">
                        <?= $total_draft; ?>
                    </h4>
                    <small class="text-secondary">Belum dipublikasikan</small>
                </div>

                <div class="draft-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
