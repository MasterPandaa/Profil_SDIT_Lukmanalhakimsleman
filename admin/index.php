<?php
session_start();
// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include database connection
include '../config/database.php';

// Cek apakah tabel-tabel sudah dibuat
$tables_exist = true;
$required_tables = ['admin', 'visi_misi', 'sambutan_kepsek', 'kurikulum', 'indikator_kelulusan', 'artikel'];

foreach ($required_tables as $table) {
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($result) == 0) {
        $tables_exist = false;
        break;
    }
}

// Jika tabel belum dibuat, arahkan ke halaman migrasi
if (!$tables_exist) {
    echo "<div style='margin: 20px; padding: 20px; border: 1px solid #ffc107; border-radius: 5px; background-color: #fff3cd; color: #856404;'>";
    echo "<h3>Persiapan Database</h3>";
    echo "<p>Beberapa tabel yang diperlukan belum tersedia di database.</p>";
    echo "<p>Silakan jalankan <a href='migrate.php'>migrasi database</a> untuk membuat tabel-tabel yang diperlukan.</p>";
    echo "</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SDIT Luqman Al Hakim Sleman</title>
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
                        <a class="nav-link active" href="index.php">
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
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> Admin
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="profile.php">Profil</a></li>
                            <li><a class="dropdown-item" href="change_password.php">Ubah Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Artikel</h6>
                                    <h2 class="mb-0">
                                        <?php
                                        $query = "SELECT COUNT(*) as total FROM artikel";
                                        $result = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['total'];
                                        ?>
                                    </h2>
                                </div>
                                <i class="fas fa-newspaper fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="artikel.php" class="text-white text-decoration-none">Lihat Detail</a>
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Prestasi</h6>
                                    <h2 class="mb-0">
                                        <?php
                                        $query = "SELECT COUNT(*) as total FROM prestasi";
                                        $result = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['total'];
                                        ?>
                                    </h2>
                                </div>
                                <i class="fas fa-trophy fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="prestasi.php" class="text-white text-decoration-none">Lihat Detail</a>
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Galeri</h6>
                                    <h2 class="mb-0">
                                        <?php
                                        $query = "SELECT COUNT(*) as total FROM galeri";
                                        $result = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['total'];
                                        ?>
                                    </h2>
                                </div>
                                <i class="fas fa-images fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="galeri.php" class="text-white text-decoration-none">Lihat Detail</a>
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Alumni</h6>
                                    <h2 class="mb-0">
                                        <?php
                                        $query = "SELECT COUNT(*) as total FROM alumni";
                                        $result = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['total'];
                                        ?>
                                    </h2>
                                </div>
                                <i class="fas fa-user-graduate fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="alumni.php" class="text-white text-decoration-none">Lihat Detail</a>
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Artikel Terbaru
                        </div>
                        <div class="card-body">
                            <?php
                            $query = "SELECT * FROM artikel ORDER BY tanggal DESC LIMIT 5";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) > 0) {
                                echo '<ul class="list-group list-group-flush">';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                    echo '<div>';
                                    echo '<h6 class="mb-0">' . htmlspecialchars($row['judul']) . '</h6>';
                                    echo '<small class="text-muted">' . date('d F Y', strtotime($row['tanggal'])) . ' - ' . htmlspecialchars($row['kategori']) . '</small>';
                                    echo '</div>';
                                    echo '<a href="artikel_edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p class="text-muted">Belum ada artikel.</p>';
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <a href="artikel.php" class="btn btn-sm btn-primary">Lihat Semua Artikel</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-tools me-1"></i>
                            Alat Bantu
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="migrate.php" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Migrasi Database</h6>
                                        <small><i class="fas fa-database"></i></small>
                                    </div>
                                    <p class="mb-1">Buat database dan tabel-tabel yang diperlukan</p>
                                </a>
                                <a href="../config/check_connection.php" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Cek Koneksi Database</h6>
                                        <small><i class="fas fa-plug"></i></small>
                                    </div>
                                    <p class="mb-1">Periksa koneksi dan status tabel database</p>
                                </a>
                                <a href="pengaturan.php" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Pengaturan Website</h6>
                                        <small><i class="fas fa-cog"></i></small>
                                    </div>
                                    <p class="mb-1">Konfigurasi pengaturan umum website</p>
                                </a>
                            </div>
                        </div>
                    </div>
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