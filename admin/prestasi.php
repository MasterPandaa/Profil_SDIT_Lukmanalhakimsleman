<?php
session_start();
// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include database connection
include '../config/database.php';

// Proses hapus prestasi
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil informasi foto prestasi sebelum dihapus
    $query = "SELECT foto FROM prestasi WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $foto);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    // Hapus data dari database
    $query = "DELETE FROM prestasi WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Hapus file foto jika ada
        if (!empty($foto) && file_exists('../assets/images/prestasi/' . $foto)) {
            unlink('../assets/images/prestasi/' . $foto);
        }
        
        $message = "Prestasi berhasil dihapus!";
        $message_type = "success";
    } else {
        $message = "Error: " . mysqli_error($conn);
        $message_type = "danger";
    }
    
    mysqli_stmt_close($stmt);
}

// Ambil daftar prestasi
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Query dengan pencarian
if (!empty($search)) {
    $query = "SELECT * FROM prestasi WHERE judul LIKE ? OR deskripsi LIKE ? ORDER BY tanggal DESC LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($conn, $query);
    $search_param = "%$search%";
    mysqli_stmt_bind_param($stmt, "ssii", $search_param, $search_param, $limit, $offset);
} else {
    $query = "SELECT * FROM prestasi ORDER BY tanggal DESC LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$prestasis = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Hitung total prestasi untuk pagination
if (!empty($search)) {
    $query = "SELECT COUNT(*) as total FROM prestasi WHERE judul LIKE ? OR deskripsi LIKE ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $search_param, $search_param);
} else {
    $query = "SELECT COUNT(*) as total FROM prestasi";
    $stmt = mysqli_prepare($conn, $query);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];
$total_pages = ceil($total_records / $limit);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Prestasi - Admin Panel</title>
    <link rel="shortcut icon" href="../assets/images/x-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                <h1 class="h2">Kelola Prestasi</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="prestasi_tambah.php" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Prestasi
                    </a>
                </div>
            </div>

            <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-body">
                    <form action="" method="get" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari prestasi..." name="search" value="<?php echo htmlspecialchars($search); ?>">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <?php if (!empty($search)): ?>
                            <div class="col-md-2">
                                <a href="prestasi.php" class="btn btn-outline-secondary w-100">Reset</a>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Prestasi</h5>
                </div>
                <div class="card-body">
                    <?php if (count($prestasis) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Gambar</th>
                                        <th width="25%">Judul</th>
                                        <th width="15%">Tingkat</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = ($page - 1) * $limit + 1;
                                    foreach ($prestasis as $prestasi): 
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td>
                                                <?php if (!empty($prestasi['foto'])): ?>
                                                    <img src="../assets/images/prestasi/<?php echo htmlspecialchars($prestasi['foto']); ?>" alt="<?php echo htmlspecialchars($prestasi['judul']); ?>" class="img-thumbnail" style="max-width: 100px;">
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada gambar</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($prestasi['judul']); ?></td>
                                            <td><?php echo htmlspecialchars($prestasi['tingkat']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($prestasi['tanggal'])); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="prestasi_edit.php?id=<?php echo $prestasi['id']; ?>" class="btn btn-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="prestasi.php?action=delete&id=<?php echo $prestasi['id']; ?>" class="btn btn-danger btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page-1; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>">
                                                <i class="fas fa-angle-left"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page+1; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>">
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Belum ada prestasi.</p>
                            <a href="prestasi_tambah.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Prestasi Baru
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="assets/js/admin-script.js"></script>
</body>
</html> 