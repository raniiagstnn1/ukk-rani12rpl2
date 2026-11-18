<?php
/**
 * =================================================================
 * PROYEK UKK RPL - BEAUTY DIGITAL HUB
 * Halaman Aksi Hapus Portfolio
 * Pengembang: Rani Agustin (12 RPL)
 * =================================================================
 */
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $result = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE id_portfolio = $id");
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $nama_usaha = $data['nama_usaha'];

        // Hapus file logo jika ada
        if (!empty($data['logo']) && file_exists("uploads/" . $data['logo'])) {
            unlink("uploads/" . $data['logo']);
        }

        // Hapus file foto produk jika ada
        if (!empty($data['foto_produk']) && file_exists("uploads/" . $data['foto_produk'])) {
            unlink("uploads/" . $data['foto_produk']);
        }

        // Hapus data dari database
        $hapus_db = mysqli_query($koneksi, "DELETE FROM portfolios WHERE id_portfolio = $id");

        if ($hapus_db) {
            $ket_log = "Menghapus portofolio salon: " . $nama_usaha;
            $aksi_log = "HAPUS DATA";
            mysqli_query($koneksi, "INSERT INTO activity_logs (nama_usaha, aksi, keterangan) VALUES ('$nama_usaha', '$aksi_log', '$ket_log')");
        }
    }
}

header("Location: dashboard.php");
exit;
?>