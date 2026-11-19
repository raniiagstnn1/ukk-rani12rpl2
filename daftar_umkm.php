
<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM portfolios ORDER BY id_portfolio DESC");

if (!$query) {
    die("Gagal mengambil data UMKM: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar UMKM - Haute Couture</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #07080c;
            --bg-card: #10121a;
            --gold: #d4af37;
            --text-muted: #b2bdcf;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at 85% 0%, rgba(38,53,86,.20), transparent 34%),
                var(--bg-dark);
            color: #f5f7fc;
            min-height: 100vh;
        }

        .font-serif,
        .sidebar-brand,
        .page-title {
            font-family: 'Cormorant Garamond', serif;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: #0c0d13;
            position: fixed;
            inset: 0 auto 0 0;
            border-right: 1px solid rgba(212,175,55,.18);
            padding: 20px;
            z-index: 10;
        }

        .sidebar-brand {
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 34px;
            color: #fff;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #101116;
            background: linear-gradient(135deg, #f1d98b, #b88a24);
            box-shadow: 0 5px 18px rgba(212,175,55,.2);
        }

        .nav-link {
            color: #c0cada;
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 7px;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: .25s ease;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.07);
        }

        .nav-link.active {
            color: #17130a;
            background: linear-gradient(135deg, #e3c45f, #b78622);
            box-shadow: 0 8px 20px rgba(185,139,36,.16);
        }

        .nav-link.logout {
            color: #ff9b9b;
            background: rgba(220,53,69,.10);
        }

        .nav-link.logout:hover {
            color: #fff;
            background: rgba(220,53,69,.22);
        }

        .main-content {
            margin-left: 240px;
            padding: 30px 35px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
        }

        .page-subtitle,
        .admin-greeting {
            color: #b6c1d2;
            font-size: 13px;
        }

        .admin-greeting strong {
            color: #fff;
        }

        .table-card {
            background: linear-gradient(145deg, #12141d, #0c0e15);
            border: 1px solid rgba(212,175,55,.22);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 18px 45px rgba(0,0,0,.35);
        }

        .section-title {
            color: #fff;
            font-weight: 700;
            font-size: 18px;
        }

        .total-text {
            color: #b9c4d5;
            font-size: 12px;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #edf1f8;
            --bs-table-border-color: rgba(255,255,255,.09);
            --bs-table-hover-bg: rgba(255,255,255,.035);
            --bs-table-hover-color: #fff;
            vertical-align: middle;
            font-size: 13px;
            margin-bottom: 0;
        }

        .table thead th {
            color: #e5c65e;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: .35px;
            white-space: nowrap;
            padding: 15px 12px;
        }

        .table tbody td {
            padding: 14px 12px;
            color: #e2e8f2;
        }

        .table tbody tr:last-child td {
            border-bottom: 0;
        }

        .number-cell {
            color: #b9c4d5 !important;
            width: 48px;
        }

        .business-name {
            color: #fff;
            font-weight: 700;
        }

        .slug-link {
            color: #80cfff;
            text-decoration: none;
            font-weight: 600;
            transition: .2s ease;
        }

        .slug-link:hover {
            color: #fff;
            text-decoration: underline;
        }

        .slug-text {
            color: #bdc8d8;
        }

        .logo-thumb {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            object-fit: cover;
            background: #1b2030;
            border: 1px solid rgba(212,175,55,.32);
            padding: 3px;
            box-shadow: 0 4px 14px rgba(0,0,0,.22);
        }

        .logo-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #e4c96e;
            background: linear-gradient(145deg, #242838, #151925);
            border: 1px solid rgba(212,175,55,.28);
            font-size: 19px;
        }

        .template-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 8px;
            color: #dce7fa;
            background: rgba(92,125,180,.15);
            border: 1px solid rgba(126,158,211,.22);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-aktif {
            background: rgba(32,201,151,.13);
            color: #55e0b5;
            border: 1px solid rgba(32,201,151,.2);
        }

        .status-draft {
            background: rgba(148,163,184,.13);
            color: #c3ccda;
            border: 1px solid rgba(148,163,184,.18);
        }

        .action-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
        }

        .btn-action {
            width: 37px;
            height: 37px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            font-size: 15px;
            text-decoration: none;
            transition: .2s ease;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 16px rgba(0,0,0,.25);
        }

        .btn-view {
            color: #70d9f4;
            background: rgba(13,202,240,.10);
            border: 1px solid rgba(13,202,240,.35);
        }

        .btn-view:hover {
            color: #07141a;
            background: #70d9f4;
        }

        .btn-edit {
            color: #f1d36f;
            background: rgba(255,193,7,.10);
            border: 1px solid rgba(255,193,7,.35);
        }

        .btn-edit:hover {
            color: #211a08;
            background: #f1d36f;
        }

        .btn-delete {
            color: #ff858e;
            background: rgba(220,53,69,.10);
            border: 1px solid rgba(220,53,69,.35);
        }

        .btn-delete:hover {
            color: #fff;
            background: #dc3545;
        }

        .empty-state {
            color: #c0cada !important;
        }

        @media (max-width: 991px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 22px 16px;
            }

            .table-card {
                padding: 18px;
            }

            .page-title {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

<div class="sidebar d-none d-lg-block">

    <div class="sidebar-brand">
        <div class="brand-mark">
            <i class="bi bi-stars"></i>
        </div>
        <span>Haute Couture</span>
    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link active" href="daftar_umkm.php">
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
            <a class="nav-link logout" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </li>

    </ul>
</div>

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light border-opacity-10 flex-wrap gap-3">

        <div>
            <h3 class="page-title mb-1">
                Daftar UMKM Pelanggan
            </h3>

            <p class="page-subtitle mb-0">
                Kelola seluruh data UMKM yang telah terdaftar.
            </p>
        </div>

        <div class="admin-greeting">
            Halo,
            <strong>
                <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?>
            </strong>
        </div>

    </div>

    <div class="table-card">

        <div class="mb-4">
            <h5 class="section-title mb-1">
                Data Pelanggan UMKM
            </h5>

            <small class="total-text">
                Total <?= mysqli_num_rows($query); ?> UMKM terdaftar
            </small>
        </div>

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Logo</th>
                        <th>Nama Usaha</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (mysqli_num_rows($query) > 0): ?>

                        <?php $no = 1; ?>

                        <?php while ($row = mysqli_fetch_assoc($query)): ?>

                            <?php
                            $status = strtolower($row['status'] ?? '');
                            $template = $row['template'] ?? 'template1';

                            $halaman = in_array(
                                $template,
                                ['template1', 'template2', 'template3'],
                                true
                            ) ? $template . '.php' : 'template1.php';

                            $logo = $row['logo'] ?? '';
                            $logoPath = 'uploads/' . basename($logo);
                            $logoAda = !empty($logo) && is_file($logoPath);
                            ?>

                            <tr>

                                <td class="number-cell">
                                    <?= $no++; ?>
                                </td>

                                <td class="text-center">

                                    <?php if ($logoAda): ?>

                                        <img
                                            src="<?= htmlspecialchars($logoPath); ?>"
                                            alt="Logo <?= htmlspecialchars($row['nama_usaha'] ?? 'UMKM'); ?>"
                                            class="logo-thumb"
                                        >

                                    <?php else: ?>

                                        <span class="logo-placeholder" title="Logo belum tersedia">
                                            <i class="bi bi-shop"></i>
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <span class="business-name">
                                        <?= htmlspecialchars($row['nama_usaha'] ?? '-'); ?>
                                    </span>
                                </td>

                                <td>

                                    <?php if ($status === 'aktif'): ?>

                                        <a
                                            href="<?= htmlspecialchars($halaman); ?>?slug=<?= urlencode($row['slug']); ?>"
                                            target="_blank"
                                            class="slug-link"
                                            title="Buka website UMKM"
                                        >
                                            <?= htmlspecialchars($row['slug']); ?>
                                            <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>

                                    <?php else: ?>

                                        <span class="slug-text">
                                            <?= htmlspecialchars($row['slug'] ?? '-'); ?>
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <span class="template-badge">
                                        <?= htmlspecialchars($template); ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="status <?= $status === 'aktif' ? 'status-aktif' : 'status-draft'; ?>">
                                        <?= htmlspecialchars($row['status'] ?? '-'); ?>
                                    </span>
                                </td>

                                <td>

                                    <div class="action-group">

                                        <?php if ($status === 'aktif'): ?>

                                            <a
                                                href="<?= htmlspecialchars($halaman); ?>?slug=<?= urlencode($row['slug']); ?>"
                                                target="_blank"
                                                class="btn-action btn-view"
                                                title="Lihat website"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>

                                        <?php endif; ?>

                                        <a
                                            href="edit_portfolio.php?id=<?= (int)$row['id_portfolio']; ?>"
                                            class="btn-action btn-edit"
                                            title="Edit UMKM"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a
                                            href="hapus.php?id=<?= (int)$row['id_portfolio']; ?>"
                                            onclick="return confirm('Yakin ingin menghapus data UMKM ini?')"
                                            class="btn-action btn-delete"
                                            title="Hapus UMKM"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7" class="text-center empty-state py-5">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada data UMKM pelanggan.
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
