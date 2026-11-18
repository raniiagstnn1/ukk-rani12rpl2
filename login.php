<?php
/**
 * =================================================================
 * HALAMAN LOGIN ADMIN - BEAUTY DIGITAL HUB
 * Layout Split-Screen (Form Kiri, Animasi Gradasi Kanan)
 * =================================================================
 */
session_start();
include 'koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Cek ke tabel admins sesuai database
    $query = mysqli_query($koneksi, "SELECT * FROM admins WHERE username = '$username'");
    
    if ($query && mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        
        if ($password === $row['password'] || md5($password) === $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password yang Anda masukkan salah!";
        }
    } else {
        $error = "Username tidak ditemukan di database!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Beauty Digital Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #4b1d95 0%, #6d28d9 50%, #3b0764 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #fff;
        }

        /* Container Utama */
        .main-wrapper {
            background: #1a1635;
            border-radius: 28px;
            overflow: hidden;
            width: 100%;
            max-width: 980px;
            min-height: 560px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
        }

        /* Bagian Kiri (Form Login) */
        .login-side {
            flex: 1;
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #1a1635;
            position: relative;
            z-index: 2;
            box-shadow: 15px 0 35px rgba(0, 0, 0, 0.35);
        }

        .user-avatar-ring {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 2.5px solid #00d2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            color: #00d2ff;
            font-size: 34px;
            box-shadow: 0 0 20px rgba(0, 210, 255, 0.25);
        }

        .form-label {
            color: #e2e8f0;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .input-group-custom {
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            border-radius: 50px;
            padding: 4px 18px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .input-group-custom:focus-within {
            border-color: #ff2a85;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 15px rgba(255, 42, 133, 0.3);
        }

        .input-group-custom i {
            color: #cbd5e1;
            font-size: 17px;
            margin-right: 12px;
        }

        .input-group-custom input {
            background: transparent;
            border: none;
            color: #ffffff;
            width: 100%;
            padding: 10px 0;
            font-size: 14px;
            outline: none;
        }

        .input-group-custom input::placeholder {
            color: #cbd5e1;
            opacity: 0.85;
        }

        .btn-login-pink {
            background: linear-gradient(90deg, #ff1e8a 0%, #e11d74 100%);
            border: none;
            border-radius: 50px;
            padding: 13px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            color: #ffffff;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 10px 25px rgba(255, 30, 138, 0.4);
            transition: 0.3s;
        }

        .btn-login-pink:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(255, 30, 138, 0.55);
            color: #fff;
        }

        /* Bagian Kanan (Animasi Gelombang & Cahaya) */
        .visual-side {
            flex: 1.25;
            background: #16122e;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 45px;
        }

        /* Animasi Cahaya Mengalir */
        .glow-orb-1 {
            position: absolute;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(255, 42, 133, 0.65) 0%, rgba(154, 31, 255, 0) 70%);
            border-radius: 50%;
            top: 15%;
            left: 10%;
            filter: blur(35px);
            animation: floatWave1 7s ease-in-out infinite alternate;
        }

        .glow-orb-2 {
            position: absolute;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.55) 0%, rgba(58, 123, 213, 0) 70%);
            border-radius: 50%;
            bottom: 10%;
            right: -5%;
            filter: blur(40px);
            animation: floatWave2 9s ease-in-out infinite alternate;
        }

        .glow-ribbon {
            position: absolute;
            width: 140%;
            height: 180px;
            background: linear-gradient(90deg, rgba(255, 42, 133, 0.5), rgba(138, 43, 226, 0.6), rgba(0, 210, 255, 0.5));
            top: 38%;
            left: -20%;
            border-radius: 50%;
            filter: blur(30px);
            transform: rotate(-18deg);
            animation: pulseWave 6s ease-in-out infinite alternate;
        }

        @keyframes floatWave1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(45px, -35px) scale(1.15); }
        }

        @keyframes floatWave2 {
            0% { transform: translate(0, 0) scale(1.1); }
            100% { transform: translate(-50px, 30px) scale(0.95); }
        }

        @keyframes pulseWave {
            0% { transform: rotate(-18deg) scaleY(0.9); opacity: 0.75; }
            100% { transform: rotate(-12deg) scaleY(1.25); opacity: 1; }
        }

        .top-nav-links {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .top-nav-links a {
            color: #e2e8f0;
            text-decoration: none;
            transition: 0.2s;
        }

        .top-nav-links a:hover {
            color: #00d2ff;
        }

        .btn-landing-pill {
            background: #0099cc;
            color: #fff !important;
            padding: 7px 18px;
            border-radius: 50px;
        }

        .welcome-text-box {
            position: relative;
            z-index: 2;
            text-align: right;
            margin-top: auto;
            margin-bottom: 20px;
        }

        .welcome-text-box h1 {
            font-size: 46px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .welcome-text-box p {
            color: #e2e8f0;
            font-size: 13.5px;
            line-height: 1.6;
            max-width: 340px;
            margin-left: auto;
        }

        @media (max-width: 768px) {
            .visual-side {
                display: none;
            }
            .login-side {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <!-- SEBELAH KIRI: FORM LOGIN -->
        <div class="login-side">
            <div class="text-center mb-2">
                <div class="user-avatar-ring">
                    <i class="bi bi-person"></i>
                </div>
                <h5 class="fw-bold text-white mb-1">BEAUTY DIGITAL HUB</h5>
                <p class="small mb-4" style="color: #cbd5e1;">Panel Administrator</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger bg-danger text-white border-0 py-2 small rounded-pill mb-3 text-center fw-semibold">
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person"></i>
                        <input type="text" name="username" placeholder="Masukkan username (admin)" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password (12345)" required>
                    </div>
                </div>

                <button type="submit" name="login" class="btn btn-login-pink">LOGIN</button>
            </form>
        </div>

        <!-- SEBELAH KANAN: ANIMASI GELOMBANG CAHAYA & WELCOME -->
        <div class="visual-side">
            <!-- Efek Animasi -->
            <div class="glow-orb-1"></div>
            <div class="glow-orb-2"></div>
            <div class="glow-ribbon"></div>

            <!-- Navigasi Atas Kanan -->
            <div class="top-nav-links">
                <a href="index.php">BERANDA</a>
                <a href="index.php" class="btn-landing-pill">LIHAT WEB</a>
            </div>

            <!-- Teks Welcome -->
            <div class="welcome-text-box">
                <h1>Welcome.</h1>
                <p>Kelola portofolio website UMKM salon klien secara cepat, modern, dan terintegrasi dalam satu dashboard.</p>
            </div>
        </div>
    </div>

</body>
</html>