<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Program Studi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container my-5">

    <!-- HEADER HALAMAN -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">
                <i class="bi bi-mortarboard-fill text-primary"></i> Program Studi
            </h3>
            <small class="text-muted">Manajemen data program studi</small>
        </div>

        <div class="d-flex gap-2">
            <a href="../mahasiswa/index.php" class="btn btn-outline-primary">
                <i class="bi bi-people-fill"></i> Mahasiswa
            </a>
            <a href="create_prodi.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Prodi
            </a>
        </div>
    </div>

    <!-- ALERT -->
    <?php
    if (isset($_GET['pesan'])) {
        $alert = [
            "sukses_tambah" => ["success", "Data program studi berhasil ditambahkan"],
            "sukses_update" => ["success", "Data program studi berhasil diperbarui"],
            "sukses_hapus"  => ["success", "Data program studi berhasil dihapus"],
            "gagal"         => ["danger", "Terjadi kesalahan sistem"]
        ];

        if (isset($alert[$_GET['pesan']])) {
            [$type, $text] = $alert[$_GET['pesan']];
            echo "
            <div class='alert alert-$type alert-dismissible fade show'>
                <i class='bi bi-info-circle'></i> $text
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
        }
    }
    ?>
//.
    <!-- CARD TABEL -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Prodi</th>
                            <th width="120">Jenjang</th>
                            <th>Keterangan</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        include "koneksi_akademik.php";
                        $no = 1;
                        $tampil = $db->query("SELECT * FROM prodi ORDER BY jenjang ASC");

                        while ($data = $tampil->fetch_assoc()) :
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($data['nama_prodi']); ?></td>
                            <td class="text-center">
                                <span class="badge bg-primary px-3 py-2">
                                    <?= htmlspecialchars($data['jenjang']); ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($data['keterangan']); ?></td>
                            <td class="text-center">
                                <a href="edit_prodi.php?id=<?= $data['id']; ?>" 
                                   class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="delete_prodi.php?id=<?= $data['id']; ?>" 
                                   class="btn btn-danger btn-sm" title="Hapus"
                                   onclick="return confirm('Yakin ingin menghapus program studi ini?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
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
