<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Studi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .card {
            border-radius: 12px;
            border: none;
            overflow: hidden;
        }
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2d3748;
            border-bottom: 2px solid #e9ecef;
            padding: 12px 16px;
        }
        .table td {
            padding: 12px 16px;
            vertical-align: middle;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        .header-section {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
        }
        .btn {
            border-radius: 8px;
            padding: 8px 16px;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <!-- Header -->
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-2"><i class="bi bi-mortarboard-fill me-2"></i>Program Studi</h2>
                <p class="mb-0 opacity-75">Manajemen data program studi</p>
            </div>
            <div class="d-flex gap-2">
                <a href="../mahasiswa/index.php" class="btn btn-light">
                    <i class="bi bi-people-fill me-2"></i>Mahasiswa
                </a>
                <a href="create_prodi.php" class="btn btn-light">
                    <i class="bi bi-plus-circle me-2"></i>Tambah
                </a>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php if (isset($_GET['pesan'])) : 
        $alert = [
            "sukses_tambah" => ["success", "Prodi berhasil ditambahkan"],
            "sukses_update" => ["success", "Prodi berhasil diperbarui"],
            "sukses_hapus"  => ["success", "Prodi berhasil dihapus"],
            "gagal"         => ["danger", "Terjadi kesalahan"]
        ];
        if (isset($alert[$_GET['pesan']])) :
            [$type, $text] = $alert[$_GET['pesan']]; ?>
            <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $text ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; 
    endif; ?>

    <!-- Tabel -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Prodi</th>
                            <th width="100">Jenjang</th>
                            <th>Keterangan</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "koneksi_akademik.php";
                        $no = 1;
                        $tampil = $db->query("SELECT * FROM prodi ORDER BY jenjang ASC");
                        while ($data = $tampil->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($data['nama_prodi']); ?></td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <?= htmlspecialchars($data['jenjang']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 300px;">
                                    <?= htmlspecialchars($data['keterangan']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="edit_prodi.php?id=<?= $data['id']; ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete_prodi.php?id=<?= $data['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Hapus program studi?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>