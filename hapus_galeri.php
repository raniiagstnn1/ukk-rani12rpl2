<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id_galeri = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_portfolio = isset($_GET['portfolio_id']) ? intval($_GET['portfolio_id']) : 0;

if ($id_galeri > 0) {
    // Ambil nama file foto di tabel portfolio_images
    $query = mysqli_query($koneksi, "SELECT * FROM portfolio_images WHERE id = $id_galeri");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $file_foto = $data['foto'];
        // Hapus file fisik dari folder uploads
        if (!empty($file_foto) && file_exists("uploads/" . $file_foto)) {
            unlink("uploads/" . $file_foto);
        }
        // Hapus baris dari database
        mysqli_query($koneksi, "DELETE FROM portfolio_images WHERE id = $id_galeri");
    }
}

// Kembalikan ke halaman edit portofolio
header("Location: edit_portfolio.php?id=" . $id_portfolio);
exit;
?>