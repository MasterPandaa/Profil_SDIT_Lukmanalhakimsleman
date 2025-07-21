<?php
session_start();
// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include database connection
include '../config/database.php';

// Cek ID prestasi
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: prestasi.php");
    exit;
}

$id = $_GET['id'];

// Ambil data prestasi
$query = "SELECT * FROM prestasi WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header("Location: prestasi.php");
    exit;
}

$prestasi = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Proses update prestasi
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $tingkat = $_POST['tingkat'];
    
    // Upload foto jika ada
    $foto = $prestasi['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($ext), $allowed)) {
            // Generate unique filename
            $newname = 'prestasi_' . time() . '.' . $ext;
            $target = '../assets/images/prestasi/' . $newname;
            
            // Cek direktori
            if (!is_dir('../assets/images/prestasi/')) {
                mkdir('../assets/images/prestasi/', 0777, true);
            }
            
            // Upload file
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                // Hapus foto lama jika ada
                if (!empty($prestasi['foto']) && file_exists('../assets/images/prestasi/' . $prestasi['foto'])) {
                    unlink('../assets/images/prestasi/' . $prestasi['foto']);
                }
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
    
    // Update data jika tidak ada error
    if (empty($message)) {
        $query = "UPDATE prestasi SET judul = ?, deskripsi = ?, tanggal = ?, tingkat = ?, foto = ?, updated_at = NOW() WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $judul, $deskripsi, $tanggal, $tingkat, $foto, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Prestasi berhasil diperbarui!";
            $message_type = "success";
            
            // Refresh data prestasi
            $query = "SELECT * FROM prestasi WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $prestasi = mysqli_fetch_assoc($result);
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
    <title>Edit Prestasi - Admin Panel</title>
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
                        <a class="nav-link active" href="prestasi.php">
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
                <h1 class="h2">Edit Prestasi</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="prestasi.php" class="btn btn-sm btn-outline-secondary">
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
                    <h5 class="card-title mb-0">Form Edit Prestasi</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Prestasi</label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($prestasi['judul']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?php echo htmlspecialchars($prestasi['deskripsi']); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Prestasi</label>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Ukuran maksimal: 2MB.</small>
                                </div>
                                <?php if (!empty($prestasi['foto'])): ?>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Saat Ini</label>
                                        <div>
                                            <img src="../assets/images/prestasi/<?php echo htmlspecialchars($prestasi['foto']); ?>" alt="Foto Prestasi" class="img-thumbnail img-preview" style="max-width: 200px;">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($prestasi['tanggal']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tingkat" class="form-label">Tingkat</label>
                                    <select class="form-select" id="tingkat" name="tingkat" required>
                                        <option value="">Pilih Tingkat</option>
                                        <option value="Sekolah" <?php echo ($prestasi['tingkat'] == 'Sekolah') ? 'selected' : ''; ?>>Sekolah</option>
                                        <option value="Kecamatan" <?php echo ($prestasi['tingkat'] == 'Kecamatan') ? 'selected' : ''; ?>>Kecamatan</option>
                                        <option value="Kabupaten" <?php echo ($prestasi['tingkat'] == 'Kabupaten') ? 'selected' : ''; ?>>Kabupaten</option>
                                        <option value="Provinsi" <?php echo ($prestasi['tingkat'] == 'Provinsi') ? 'selected' : ''; ?>>Provinsi</option>
                                        <option value="Nasional" <?php echo ($prestasi['tingkat'] == 'Nasional') ? 'selected' : ''; ?>>Nasional</option>
                                        <option value="Internasional" <?php echo ($prestasi['tingkat'] == 'Internasional') ? 'selected' : ''; ?>>Internasional</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Terakhir diperbarui: <?php echo date('d F Y H:i', strtotime($prestasi['updated_at'])); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="prestasi.php" class="btn btn-outline-secondary">Batal</a>
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
        .create(document.querySelector('#deskripsi'), {
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
                const imgPreview = document.querySelector('.img-preview');
                if (imgPreview) {
                    imgPreview.src = e.target.result;
                } else {
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'img-thumbnail img-preview';
                    newImg.style.maxWidth = '200px';
                    document.querySelector('#foto').parentNode.appendChild(newImg);
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html> 