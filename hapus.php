<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : ''; // 'logo' atau 'foto_produk'

if ($id > 0 && ($jenis == 'logo' || $jenis == 'foto_produk')) {
    // Ambil nama file foto saat ini
    $query = mysqli_query($koneksi, "SELECT $jenis FROM portfolios WHERE id_portfolio = $id");
    $data = mysqli_fetch_assoc($query);

    if ($data && !empty($data[$jenis])) {
        $nama_file = $data[$jenis];
        // Hapus file fisik di folder uploads jika bukan default
        if ($nama_file != 'default.png' && file_exists("uploads/" . $nama_file)) {
            unlink("uploads/" . $nama_file);
        }

        // Kosongkan kolom di database
        mysqli_query($koneksi, "UPDATE portfolios SET $jenis = '' WHERE id_portfolio = $id");
    }
}

// Redirect kembali ke halaman edit portofolio
header("Location: edit_portfolio.php?id=" . $id);
exit;
?>