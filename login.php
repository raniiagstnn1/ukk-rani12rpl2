<?php
/**
- =================================================================
- HALAMAN LOGIN ADMIN - LUXURY BLACK & GOLD EDITION
- Layout Split-Screen (Form Kiri, Animasi Gradasi Kanan)
- =================================================================
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
    <title>Login Admin - Haute Couture Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #12100e 0%, #060608 70%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #fff;
        }
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }

        /* Container Utama */
        .main-wrapper {
            background: #0d0d12;
            border-radius: 28px;
            overflow: hidden;
            width: 100%;
            max-width: 980px;
            min-height: 560px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.3);
            display: flex;
        }

        /* Bagian Kiri (Form Login) */
        .login-side {
            flex: 1;
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #0d0d12;
            position: relative;
            z-index: 2;
            box-shadow: 15px 0 35px rgba(0, 0, 0, 0.5);
        }

        .user-avatar-ring {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 2px solid #d4af37;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            color: #f3e5ab;
            font-size: 32px;
            background: rgba(212, 175, 55, 0.08);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }

        .form-label {
            color: #cbd5e1;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .input-group-custom {
            background: rgba(255, 255, 255, 0.03);
            border: 1.5px solid rgba(212, 175, 55, 0.25);
            border-radius: 50px;
            padding: 4px 18px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .input-group-custom:focus-within {
            border-color: #d4af37;
            background: rgba(212, 175, 55, 0.06);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.25);
        }

        .input-group-custom i {
            color: #d4af37;
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
            color: #64748b;
            opacity: 0.85;
        }

        .btn-login-gold {
            background: linear-gradient(135deg, #d4af37 0%, #aa771c 100%);
            border: none;
            border-radius: 50px;
            padding: 13px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            color: #060608;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
            transition: 0.3s;
        }

        .btn-login-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(212, 175, 55, 0.45);
            background: linear-gradient(135deg, #e5c158 0%, #c48b22 100%);
            color: #060608;
        }

        /* Bagian Kanan (Animasi Gelombang & Cahaya Emas) */
        .visual-side {
            flex: 1.25;
            background: #08080c;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 45px;
        }

        /* Animasi Cahaya Emas Mengalir */
        .glow-orb-1 {
            position: absolute;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.35) 0%, rgba(170, 119, 28, 0) 70%);
            border-radius: 50%;
            top: 15%;
            left: 10%;
            filter: blur(45px);
            animation: floatWave1 7s ease-in-out infinite alternate;
        }

        .glow-orb-2 {
            position: absolute;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, rgba(243, 229, 171, 0.25) 0%, rgba(13, 13, 18, 0) 70%);
            border-radius: 50%;
            bottom: 10%;
            right: -5%;
            filter: blur(50px);
            animation: floatWave2 9s ease-in-out infinite alternate;
        }

        .glow-ribbon {
            position: absolute;
            width: 140%;
            height: 180px;
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.25), rgba(243, 229, 171, 0.35), rgba(170, 119, 28, 0.25));
            top: 38%;
            left: -20%;
            border-radius: 50%;
            filter: blur(35px);
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
            0% { transform: rotate(-18deg) scaleY(0.9); opacity: 0.6; }
            100% { transform: rotate(-12deg) scaleY(1.25); opacity: 0.9; }
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
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.2s;
        }

        .top-nav-links a:hover {
            color: #f3e5ab;
        }

        .btn-landing-pill {
            background: linear-gradient(135deg, #d4af37, #aa771c);
            color: #060608 !important;
            padding: 7px 18px;
            border-radius: 50px;
            font-weight: 700;
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
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 10px;
            color: #ffffff;
            font-family: 'Cormorant Garamond', serif;
        }

        .welcome-text-box h1 span {
            background: linear-gradient(135deg, #f3e5ab 0%, #d4af37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-text-box p {
            color: #94a3b8;
            font-size: 13.5px;
            line-height: 1.6;
            max-width: 340px;
            margin-left: auto;
            font-weight: 300;
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
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h5 class="fw-bold text-white font-serif mb-1" style="font-size: 24px;">HAUTE COUTURE DIGITAL</h5>
                <p class="small mb-4" style="color: #94a3b8;">Admin Portal & Management</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger text-white py-2 small rounded-pill mb-3 text-center fw-semibold">
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person"></i>
                        <input type="text" name="username" placeholder="Masukkan username admin" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" name="login" class="btn btn-login-gold">MASUK KE DASHBOARD</button>
            </form>
        </div>

        <!-- SEBELAH KANAN: ANIMASI GELOMBANG CAHAYA EMAS & WELCOME -->
        <div class="visual-side">
            <!-- Efek Animasi Emas -->
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
                <h1>Welcome, <span>Admin.</span></h1>
                <p>Kelola portofolio website salon mitra eksklusif secara cepat, modern, dan terintegrasi dalam satu dashboard mewah.</p>
            </div>
        </div>
    </div>

</body>
</html>