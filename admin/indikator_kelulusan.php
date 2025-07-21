<?php
session_start();
// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include database connection
include '../config/database.php';

// Proses update data
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $konten = $_POST['konten'];
    
    // Update data
    $query = "UPDATE indikator_kelulusan SET judul = ?, deskripsi = ?, konten = ?, updated_at = NOW() WHERE id = 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $judul, $deskripsi, $konten);
    
    if (mysqli_stmt_execute($stmt)) {
        $message = "Indikator Kelulusan berhasil diperbarui!";
        $message_type = "success";
    } else {
        $message = "Error: " . mysqli_error($conn);
        $message_type = "danger";
    }
    
    mysqli_stmt_close($stmt);
}

// Ambil data indikator kelulusan
$query = "SELECT * FROM indikator_kelulusan WHERE id = 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indikator Kelulusan - Admin Panel</title>
    <link rel="shortcut icon" href="../assets/images/x-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <h4 class="text-white">Admin Panel</h4>
                    <p class="text-white-50">SDIT Luqman Al Hakim</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="visi_misi.php">
                            <i class="fas fa-bullseye"></i> Visi & Misi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sambutan_kepsek.php">
                            <i class="fas fa-user-tie"></i> Sambutan Kepsek
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kurikulum.php">
                            <i class="fas fa-book"></i> Kurikulum
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="indikator_kelulusan.php">
                            <i class="fas fa-graduation-cap"></i> Indikator Kelulusan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="prestasi.php">
                            <i class="fas fa-trophy"></i> Prestasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ekstrakurikuler.php">
                            <i class="fas fa-futbol"></i> Ekstrakurikuler
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="fasilitas.php">
                            <i class="fas fa-building"></i> Fasilitas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeri.php">
                            <i class="fas fa-images"></i> Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="alumni.php">
                            <i class="fas fa-user-graduate"></i> Alumni
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="artikel.php">
                            <i class="fas fa-newspaper"></i> Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengaturan.php">
                            <i class="fas fa-cog"></i> Pengaturan
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Indikator Kelulusan</h1>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Indikator Kelulusan</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($data['judul'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2" required><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="konten" class="form-label">Konten Lengkap</label>
                            <textarea class="form-control" id="konten" name="konten" rows="10" required><?php echo htmlspecialchars($data['konten'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Terakhir diperbarui: <?php echo date('d F Y H:i', strtotime($data['updated_at'] ?? 'now')); ?></small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="assets/js/admin-script.js"></script>
<script>
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#deskripsi'))
        .catch(error => {
            console.error(error);
        });
        
    ClassicEditor
        .create(document.querySelector('#konten'))
        .catch(error => {
            console.error(error);
        });
</script>
</body>
</html> 