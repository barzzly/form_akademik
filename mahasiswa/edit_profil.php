<?php
session_start();
include "koneksi_akademik.php";

// Cek login
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$nim = $_SESSION['nim'];
$query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
$result = $db->query($query);
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: logout.php");
    exit();
}

// Proses update jika ada POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $db->real_escape_string($_POST['nama_mahasiswa']);
    $no_hp = $db->real_escape_string($_POST['no_hp']);
    $password = $_POST['password'];
    
    // Validasi input
    $errors = [];
    
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    }
    
    if (!empty($password) && strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter";
    }
    
    if (empty($errors)) {
        // Update query
        if (!empty($password)) {
            // Enkripsi password dengan MD5 (untuk demo)
            $password_encrypted = md5($password);
            $update_query = "UPDATE mahasiswa SET 
                            nama_mahasiswa = '$nama', 
                            no_hp = '$no_hp', 
                            password = '$password_encrypted' 
                            WHERE nim = '$nim'";
        } else {
            $update_query = "UPDATE mahasiswa SET 
                            nama_mahasiswa = '$nama', 
                            no_hp = '$no_hp' 
                            WHERE nim = '$nim'";
        }
        
        if ($db->query($update_query)) {
            $_SESSION['nama'] = $nama;
            header("Location: profil.php?pesan=update_success");
            exit();
        } else {
            $error_msg = "Gagal memperbarui profil: " . $db->error;
        }
    } else {
        $error_msg = implode("<br>", $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .edit-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .edit-header {
            background: linear-gradient(90deg, #ff9a9e 0%, #fad0c4 100%);
            color: #333;
            padding: 25px;
            text-align: center;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e1e5eb;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 0.3rem rgba(74, 108, 247, 0.15);
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        .btn-save {
            background: linear-gradient(90deg, #4a6cf7 0%, #6a11cb 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-cancel {
            background: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e1e5eb;
            border-right: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #4a6cf7 0%, #6a11cb 100%);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Sistem Akademik
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">
                            <i class="bi bi-person-circle me-1"></i>Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="edit-card card">
                    <div class="edit-header">
                        <h4 class="fw-bold">Edit Profil Mahasiswa</h4>
                        <p class="mb-0">Perbarui data pribadi Anda</p>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <?php if (isset($error_msg)): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error_msg; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <!-- NIM (Readonly) -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person-vcard text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['nim']); ?>" readonly>
                                </div>
                                <div class="form-text text-muted">NIM tidak dapat diubah</div>
                            </div>
                            
                            <!-- Email (Readonly) -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>
                                    <input type="email" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['email']); ?>" readonly>
                                </div>
                                <div class="form-text text-muted">Email tidak dapat diubah</div>
                            </div>
                            
                            <!-- Nama Lengkap (Editable) -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person-fill text-primary"></i>
                                    </span>
                                    <input type="text" name="nama_mahasiswa" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['nama_mahasiswa']); ?>" 
                                           placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>
                            
                            <!-- No HP (Editable) -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">No. Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-phone text-primary"></i>
                                    </span>
                                    <input type="text" name="no_hp" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['no_hp'] ?? ''); ?>" 
                                           placeholder="Contoh: 081234567890">
                                </div>
                            </div>
                            
                            <!-- Password (Editable) -->
                            <div class="mb-5">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock text-primary"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="Kosongkan jika tidak ingin mengubah">
                                </div>
                                <div class="form-text text-muted">Minimal 6 karakter</div>
                            </div>
                            
                            <!-- Tombol Aksi -->
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <a href="profil.php" class="btn btn-cancel">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-save">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
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