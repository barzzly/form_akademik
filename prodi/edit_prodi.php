<?php
include "koneksi_akademik.php";

if (!isset($_GET['id'])) {
    header("Location: index_prodi.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data prodi
$stmt = $db->prepare("SELECT * FROM prodi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data program studi tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Program Studi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="text-center mb-4 fw-bold">Edit Program Studi</h3>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST" action="update_prodi.php">

                        <!-- ID (hidden) -->
                        <input type="hidden" name="id" value="<?= $data['id']; ?>">

                        <!-- Nama Prodi -->
                        <div class="mb-3">
                            <label class="form-label">Nama Program Studi</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="nama_prodi" 
                                   value="<?= htmlspecialchars($data['nama_prodi']); ?>" 
                                   required>
                        </div>

                        <!-- Jenjang -->
                        <div class="mb-3">
                            <label class="form-label">Jenjang</label>
                            <select name="jenjang" class="form-select" required>
                                <option value="D3" <?= $data['jenjang']=='D3'?'selected':''; ?>>D3</option>
                                <option value="D4" <?= $data['jenjang']=='D4'?'selected':''; ?>>D4</option>
                                <option value="S1" <?= $data['jenjang']=='S1'?'selected':''; ?>>S1</option>
                                <option value="S2" <?= $data['jenjang']=='S2'?'selected':''; ?>>S2</option>
                            </select>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" 
                                      name="keterangan" 
                                      rows="3" 
                                      required><?= htmlspecialchars($data['keterangan']); ?></textarea>
                        </div>
//.
                        <!-- Tombol -->
                        <div class="d-flex justify-content-between">
                            <a href="./prodi.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" name="update" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
