<?php
session_start();
include "koneksi_akademik.php";

// Jika sudah login, redirect berdasarkan role
if (isset($_SESSION['nim'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $db->real_escape_string($_POST['nim']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $result = $db->query($query);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password (MD5 untuk demo, sebaiknya gunakan password_hash())
        if (md5($password) === $user['password'] || $password === $user['password']) {
            $_SESSION['nim'] = $user['nim'];
            $_SESSION['nama'] = $user['nama_mahasiswa'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'] ?? 'mahasiswa';
            
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "NIM tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e1e5eb;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.15);
        }
        .btn-login {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <div class="login-header">
                        <h3><i class="bi bi-mortarboard-fill"></i> Sistem Akademik</h3>
                        <p class="mb-0">Login untuk mengakses sistem</p>
                    </div>
                    <div class="login-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-4">
                                <label class="form-label">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person-vcard text-primary"></i>
                                    </span>
                                    <input type="text" name="nim" class="form-control" 
                                           placeholder="Masukkan NIM" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock text-primary"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="Masukkan password" required>
                                </div>
                                <div class="form-text">
                                    <a href="#" class="text-decoration-none">Lupa password?</a>
                                </div>
                            </div>
                            <!-- Di bagian bawah form login, tambahkan: -->
                            <div class="text-center mt-4">
                                <p class="mb-2">Belum punya akun?</p>
                                <a href="register.php" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-person-plus me-1"></i>Daftar Akun Baru
                                </a>
                            </div>
                            <button type="submit" class="btn btn-login mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>
                            

                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>