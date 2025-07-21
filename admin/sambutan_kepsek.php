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
    $nama_kepsek = $_POST['nama_kepsek'];
    $sambutan = $_POST['sambutan'];
    
    // Cek apakah ada file foto yang diupload
    if (isset($_FILES['foto_kepsek']) && $_FILES['foto_kepsek']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto_kepsek']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($ext), $allowed)) {
            // Generate unique filename
            $newname = 'kepsek_' . time() . '.' . $ext;
            $target = '../assets/images/about/kepsek/' . $newname;
            
            // Cek direktori
            if (!is_dir('../assets/images/about/kepsek/')) {
                mkdir('../assets/images/about/kepsek/', 0777, true);
            }
            
            // Upload file
            if (move_uploaded_file($_FILES['foto_kepsek']['tmp_name'], $target)) {
                // Update data dengan foto baru
                $query = "UPDATE sambutan_kepsek SET nama_kepsek = ?, foto_kepsek = ?, sambutan = ?, updated_at = NOW() WHERE id = 1";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "sss", $nama_kepsek, $newname, $sambutan);
            } else {
                $message = "Error: Gagal mengupload foto.";
                $message_type = "danger";
            }
        } else {
            $message = "Error: Format file tidak diizinkan. Gunakan format JPG, JPEG, PNG, atau GIF.";
            $message_type = "danger";
        }
    } else {
        // Update data tanpa mengubah foto
        $query = "UPDATE sambutan_kepsek SET nama_kepsek = ?, sambutan = ?, updated_at = NOW() WHERE id = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $nama_kepsek, $sambutan);
    }
    
    // Execute query jika tidak ada error
    if (empty($message)) {
        if (mysqli_stmt_execute($stmt)) {
            $message = "Sambutan Kepala Sekolah berhasil diperbarui!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "danger";
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Ambil data sambutan kepsek
$query = "SELECT * FROM sambutan_kepsek WHERE id = 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sambutan Kepala Sekolah - Admin Panel</title>
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
                        <a class="nav-link active" href="sambutan_kepsek.php">
                            <i class="fas fa-user-tie"></i> Sambutan Kepsek
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kurikulum.php">
                            <i class="fas fa-book"></i> Kurikulum
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="indikator_kelulusan.php">
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
                <h1 class="h2">Sambutan Kepala Sekolah</h1>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Sambutan Kepala Sekolah</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nama_kepsek" class="form-label">Nama Kepala Sekolah</label>
                                    <input type="text" class="form-control" id="nama_kepsek" name="nama_kepsek" value="<?php echo htmlspecialchars($data['nama_kepsek'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sambutan" class="form-label">Sambutan</label>
                                    <textarea class="form-control" id="sambutan" name="sambutan" rows="10" required><?php echo htmlspecialchars($data['sambutan'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="foto_kepsek" class="form-label">Foto Kepala Sekolah</label>
                                    <input type="file" class="form-control" id="foto_kepsek" name="foto_kepsek" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Ukuran maksimal: 2MB.</small>
                                </div>
                                <?php if (!empty($data['foto_kepsek'])): ?>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Saat Ini</label>
                                        <div>
                                            <img src="../assets/images/about/kepsek/<?php echo htmlspecialchars($data['foto_kepsek']); ?>" alt="Foto Kepala Sekolah" class="img-thumbnail img-preview" style="max-width: 200px;">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
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
        .create(document.querySelector('#sambutan'))
        .catch(error => {
            console.error(error);
        });
        
    // Image preview
    document.getElementById('foto_kepsek').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgPreview = document.querySelector('.img-preview');
                if (imgPreview) {
                    imgPreview.src = e.target.result;
                } else {
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'img-thumbnail img-preview';
                    newImg.style.maxWidth = '200px';
                    document.querySelector('#foto_kepsek').parentNode.appendChild(newImg);
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html> 