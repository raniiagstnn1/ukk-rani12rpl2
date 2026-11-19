
<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';

if ($id <= 0) {
    header("Location: daftar_umkm.php");
    exit;
}

if ($jenis == 'logo' || $jenis == 'foto_produk') {

    $stmt = mysqli_prepare($koneksi, "SELECT $jenis FROM portfolios WHERE id_portfolio = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if ($data && !empty($data[$jenis])) {
        $nama_file = basename($data[$jenis]);
        $path = "uploads/" . $nama_file;

        $update = mysqli_prepare($koneksi, "UPDATE portfolios SET $jenis = '' WHERE id_portfolio = ?");
        mysqli_stmt_bind_param($update, "i", $id);
        mysqli_stmt_execute($update);

        if ($nama_file != 'default.png' && is_file($path)) {
            unlink($path);
        }
    }

    header("Location: edit_portfolio.php?id=" . $id);
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM portfolios WHERE id_portfolio = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: daftar_umkm.php");
    exit;
}

$daftar_foto = [];

if (!empty($data['logo'])) {
    $daftar_foto[] = basename($data['logo']);
}

if (!empty($data['foto_produk'])) {
    $daftar_foto[] = basename($data['foto_produk']);
}

$stmt_galeri = mysqli_prepare($koneksi, "SELECT foto FROM portfolio_images WHERE portfolio_id = ?");
mysqli_stmt_bind_param($stmt_galeri, "i", $id);
mysqli_stmt_execute($stmt_galeri);

$result_galeri = mysqli_stmt_get_result($stmt_galeri);

while ($galeri = mysqli_fetch_assoc($result_galeri)) {
    if (!empty($galeri['foto'])) {
        $daftar_foto[] = basename($galeri['foto']);
    }
}

mysqli_begin_transaction($koneksi);

try {
    $stmt_galeri_hapus = mysqli_prepare($koneksi, "DELETE FROM portfolio_images WHERE portfolio_id = ?");
    mysqli_stmt_bind_param($stmt_galeri_hapus, "i", $id);

    if (!mysqli_stmt_execute($stmt_galeri_hapus)) {
        throw new Exception(mysqli_error($koneksi));
    }

    $stmt_hapus = mysqli_prepare($koneksi, "DELETE FROM portfolios WHERE id_portfolio = ?");
    mysqli_stmt_bind_param($stmt_hapus, "i", $id);

    if (!mysqli_stmt_execute($stmt_hapus)) {
        throw new Exception(mysqli_error($koneksi));
    }

    mysqli_commit($koneksi);

    foreach (array_unique($daftar_foto) as $nama_file) {
        if ($nama_file != 'default.png') {
            $path = "uploads/" . $nama_file;

            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    echo "<script>
    alert('Data UMKM berhasil dihapus!');
    window.location.href = 'daftar_umkm.php';
</script>";
exit;

} catch (Exception $e) {
    mysqli_rollback($koneksi);

    die("Gagal menghapus data UMKM: " . htmlspecialchars($e->getMessage()));
}
?>
