<?php
/**
 * =================================================================
 * PROYEK UKK RPL - BEAUTY DIGITAL HUB
 * File Router Dinamis: salon.php
 * Pengembang: Rani Agustin (12 RPL)
 * =================================================================
 */
include 'koneksi.php';

// Pastikan ada parameter slug yang dikirim di URL (contoh: salon.php?slug=...)
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header("Location: index.php");
    exit;
}

$slug = mysqli_real_escape_string($koneksi, $_GET['slug']);
$query = mysqli_query($koneksi, "SELECT * FROM portfolios WHERE slug='$slug'");
$data = mysqli_fetch_assoc($query);

// Jika data salon dengan slug tersebut tidak ditemukan di database
if (!$data) {
    echo "<script>alert('Website UMKM tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// Ambil pilihan template dari database (default: template1)
$template = isset($data['template']) ? $data['template'] : 'template1';

// Muat file template yang sesuai secara dinamis
if ($template == 'template2' && file_exists('template2.php')) {
    include 'template2.php';
} elseif ($template == 'template3' && file_exists('template3.php')) {
    include 'template3.php';
} else {
    // Default fallback ke template1
    if (file_exists('template1.php')) {
        include 'template1.php';
    } else {
        echo "<h3 style='text-align:center; margin-top:50px;'>Error: File template1.php belum dibuat di folder proyek!</h3>";
    }
}
?>