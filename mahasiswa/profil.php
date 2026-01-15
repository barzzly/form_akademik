<?php
session_start();
include "koneksi_akademik.php";

// Cek login
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$nim = $_SESSION['nim'];
$query = "SELECT m.*, p.nama_prodi 
          FROM mahasiswa m 
          LEFT JOIN prodi p ON m.prodi_id = p.id 
          WHERE m.nim = '$nim'";
$result = $db->query($query);
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: logout.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .profile-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .profile-header {
            background: linear-gradient(90deg, #4a6cf7 0%, #6a11cb 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .info-item {
            border-bottom: 1px solid #e9ecef;
            padding: 15px 0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
        }
        .info-value {
            color: #212529;
        }
        .btn-edit {
            background: linear-gradient(90deg, #4a6cf7 0%, #6a11cb 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profil.php">
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
            <div class="col-md-10 col-lg-8">
                <?php if (isset($_GET['pesan'])): ?>
                    <?php if ($_GET['pesan'] == 'update_success'): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle-fill me-2"></i>Profil berhasil diperbarui!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <div class="profile-card card">
                    <div class="profile-header">
                        <div class="avatar mb-3" style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); 
                              border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                              margin: 0 auto; font-size: 40px; color: white;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h4 class="fw-bold"><?php echo htmlspecialchars($data['nama_mahasiswa']); ?></h4>
                        <p class="mb-0"><?php echo htmlspecialchars($data['nim']); ?></p>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">NIM:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['nim']); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Nama Lengkap:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['nama_mahasiswa']); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['email']); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">No. HP:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['no_hp'] ?? '-'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Program Studi:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['nama_prodi'] ?? '-'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Tanggal Lahir:</span>
                                    <span class="info-value"><?php echo date('d/m/Y', strtotime($data['tanggal_lahir'])); ?></span>
                                </div>
                            </div>
                            <div class="col-12 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Alamat:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['alamat']); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-5">
                            <a href="edit_profil.php" class="btn btn-edit">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>