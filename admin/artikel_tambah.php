<?php
session_start();
// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include database connection
include '../config/database.php';

// Proses tambah artikel
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $kategori = $_POST['kategori'];
    $status = $_POST['status'];
    $tanggal = $_POST['tanggal'];
    $penulis = $_POST['penulis'];
    
    // Generate slug dari judul
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $judul));
    
    // Cek apakah slug sudah ada
    $query = "SELECT COUNT(*) as count FROM artikel WHERE slug = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if ($row['count'] > 0) {
        // Jika slug sudah ada, tambahkan timestamp
        $slug = $slug . '-' . time();
    }
    
    // Upload foto jika ada
    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($ext), $allowed)) {
            // Generate unique filename
            $newname = 'artikel_' . time() . '.' . $ext;
            $target = '../assets/images/blog/' . $newname;
            
            // Cek direktori
            if (!is_dir('../assets/images/blog/')) {
                mkdir('../assets/images/blog/', 0777, true);
            }
            
            // Upload file
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                $foto = $newname;
            } else {
                $message = "Error: Gagal mengupload foto.";
                $message_type = "danger";
            }
        } else {
            $message = "Error: Format file tidak diizinkan. Gunakan format JPG, JPEG, PNG, atau GIF.";
            $message_type = "danger";
        }
    }
    
    // Insert data jika tidak ada error
    if (empty($message)) {
        $query = "INSERT INTO artikel (judul, slug, konten, foto, kategori, status, tanggal, penulis) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssss", $judul, $slug, $konten, $foto, $kategori, $status, $tanggal, $penulis);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Artikel berhasil ditambahkan!";
            $message_type = "success";
            
            // Reset form
            $judul = $konten = $kategori = $penulis = '';
            $status = 'draft';
            $tanggal = date('Y-m-d');
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "danger";
        }
        
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel - Admin Panel</title>
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
                        <a class="nav-link active" href="artikel.php">
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
                <h1 class="h2">Tambah Artikel</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="artikel.php" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Artikel</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Artikel</label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($judul ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="konten" class="form-label">Konten</label>
                                    <textarea class="form-control" id="konten" name="konten" rows="10" required><?php echo htmlspecialchars($konten ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Gambar Artikel</label>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Ukuran maksimal: 2MB.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="Berita" <?php echo (isset($kategori) && $kategori == 'Berita') ? 'selected' : ''; ?>>Berita</option>
                                        <option value="Pengumuman" <?php echo (isset($kategori) && $kategori == 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                                        <option value="Artikel" <?php echo (isset($kategori) && $kategori == 'Artikel') ? 'selected' : ''; ?>>Artikel</option>
                                        <option value="Kegiatan" <?php echo (isset($kategori) && $kategori == 'Kegiatan') ? 'selected' : ''; ?>>Kegiatan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="draft" <?php echo (isset($status) && $status == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo (isset($status) && $status == 'published') ? 'selected' : ''; ?>>Publikasikan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($tanggal ?? date('Y-m-d')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo htmlspecialchars($penulis ?? 'Admin'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <div id="imagePreview" style="display: none; margin-top: 10px;">
                                        <img src="" alt="Preview" class="img-thumbnail img-preview" style="max-width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
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
        .create(document.querySelector('#konten'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
        
    // Image preview
    document.getElementById('foto').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.style.display = 'block';
                preview.querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html> 