<?php
session_start();
include "koneksi_akademik.php";

// Jika sudah login, redirect ke index
if (isset($_SESSION['nim'])) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nim = $db->real_escape_string($_POST['nim']);
    $nama = $db->real_escape_string($_POST['nama_mahasiswa']);
    $email = $db->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $no_hp = $db->real_escape_string($_POST['no_hp']);
    $prodi_id = (int) $_POST['prodi_id'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $db->real_escape_string($_POST['alamat']);
    
    // Validasi
    $errors = [];
    
    // Cek NIM sudah ada atau belum
    $check_nim = $db->query("SELECT nim FROM mahasiswa WHERE nim = '$nim'");
    if ($check_nim->num_rows > 0) {
        $errors[] = "NIM sudah terdaftar";
    }
    
    // Cek email sudah ada atau belum
    $check_email = $db->query("SELECT email FROM mahasiswa WHERE email = '$email'");
    if ($check_email->num_rows > 0) {
        $errors[] = "Email sudah terdaftar";
    }
    
    // Validasi password
    if (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak sama";
    }
    
    // Validasi data lainnya
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        // Enkripsi password
        $password_encrypted = md5($password);
        
        // Query insert
        $sql = "INSERT INTO mahasiswa (
                    nim, 
                    nama_mahasiswa, 
                    email, 
                    password, 
                    no_hp, 
                    prodi_id, 
                    tanggal_lahir, 
                    alamat,
                    role
                ) VALUES (
                    '$nim',
                    '$nama',
                    '$email',
                    '$password_encrypted',
                    '$no_hp',
                    '$prodi_id',
                    '$tanggal_lahir',
                    '$alamat',
                    'mahasiswa'
                )";
        
        if ($db->query($sql)) {
            $success = "Pendaftaran berhasil! Silakan login.";
        } else {
            $errors[] = "Gagal mendaftar: " . $db->error;
        }
    }
    
    if (!empty($errors)) {
        $error = implode("<br>", $errors);
    }
}

// Ambil data prodi untuk dropdown
$prodi_result = $db->query("SELECT id, nama_prodi FROM prodi ORDER BY nama_prodi ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mahasiswa - Sistem Akademik</title>
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
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
        }
        .register-header {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .register-body {
            padding: 30px;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e1e5eb;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.15);
        }
        .btn-register {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-login {
            background: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 8px;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e1e5eb;
            border-right: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="register-card">
                    <div class="register-header">
                        <h3><i class="bi bi-person-plus-fill"></i> Registrasi Mahasiswa Baru</h3>
                        <p class="mb-0">Buat akun untuk mengakses sistem akademik</p>
                    </div>
                    <div class="register-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <div class="mt-3">
                                    <a href="login.php" class="btn btn-success btn-sm">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Login Sekarang
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!$success): ?>
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-person-vcard text-primary"></i>
                                        </span>
                                        <input type="text" name="nim" class="form-control" 
                                               placeholder="Contoh: 2411083008" required
                                               value="<?php echo isset($_POST['nim']) ? htmlspecialchars($_POST['nim']) : ''; ?>">
                                    </div>
                                    <div class="form-text">NIM akan digunakan untuk login</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </span>
                                        <input type="text" name="nama_mahasiswa" class="form-control" 
                                               placeholder="Nama lengkap mahasiswa" required
                                               value="<?php echo isset($_POST['nama_mahasiswa']) ? htmlspecialchars($_POST['nama_mahasiswa']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-envelope text-primary"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control" 
                                               placeholder="contoh@email.com" required
                                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-phone text-primary"></i>
                                        </span>
                                        <input type="text" name="no_hp" class="form-control" 
                                               placeholder="081234567890"
                                               value="<?php echo isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-lock text-primary"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control" 
                                               placeholder="Minimal 6 karakter" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-lock-fill text-primary"></i>
                                        </span>
                                        <input type="password" name="confirm_password" class="form-control" 
                                               placeholder="Ulangi password" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                                    <select name="prodi_id" class="form-select" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        <?php while ($prodi = $prodi_result->fetch_assoc()): ?>
                                        <option value="<?= $prodi['id']; ?>"
                                            <?php echo (isset($_POST['prodi_id']) && $_POST['prodi_id'] == $prodi['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($prodi['nama_prodi']); ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required
                                           value="<?php echo isset($_POST['tanggal_lahir']) ? htmlspecialchars($_POST['tanggal_lahir']) : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" 
                                          placeholder="Alamat lengkap"><?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?></textarea>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-register">
                                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="login.php" class="btn btn-login">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Sudah Punya Akun? Login
                                    </a>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <p class="text-muted small mb-0">
                                    Dengan mendaftar, Anda menyetujui 
                                    <a href="#" class="text-decoration-none">Syarat & Ketentuan</a>
                                </p>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validasi form client-side
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const password = document.querySelector('input[name="password"]');
            const confirmPassword = document.querySelector('input[name="confirm_password"]');
            
            form.addEventListener('submit', function(e) {
                // Validasi password match
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak sama!');
                    confirmPassword.focus();
                    return false;
                }
                
                // Validasi panjang password
                if (password.value.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    password.focus();
                    return false;
                }
                
                return true;
            });
            
            // Format NIM input
            const nimInput = document.querySelector('input[name="nim"]');
            nimInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            // Format phone input
            const phoneInput = document.querySelector('input[name="no_hp"]');
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+]/g, '');
            });
        });
    </script>
</body>
</html>