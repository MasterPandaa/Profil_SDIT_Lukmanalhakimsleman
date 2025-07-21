<?php
session_start();
// Cek apakah sudah login untuk keamanan
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Untuk instalasi awal, kita izinkan akses tanpa login
    $allow_without_login = true;
    
    // Jika bukan instalasi awal (sudah ada tabel admin), maka wajib login
    if (file_exists('../config/database.php')) {
        include '../config/database.php';
        $result = mysqli_query($conn, "SHOW TABLES LIKE 'admin'");
        if (mysqli_num_rows($result) > 0) {
            $allow_without_login = false;
        }
    }
    
    if (!$allow_without_login) {
        header("Location: login.php");
        exit;
    }
}

// Konfigurasi Database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_sdit_lukmanalhakimsleman';

$message = '';
$message_type = '';
$logs = [];

// Proses migrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Buat koneksi ke MySQL tanpa database
    $conn = mysqli_connect($host, $username, $password);
    
    // Cek koneksi
    if (!$conn) {
        $message = "Koneksi ke server database gagal: " . mysqli_connect_error();
        $message_type = "danger";
    } else {
        // Cek apakah database sudah ada
        $result = mysqli_query($conn, "SHOW DATABASES LIKE '$database'");
        
        if (mysqli_num_rows($result) == 0) {
            // Buat database baru
            if (mysqli_query($conn, "CREATE DATABASE $database")) {
                $logs[] = "✅ Database $database berhasil dibuat.";
            } else {
                $logs[] = "❌ Error saat membuat database: " . mysqli_error($conn);
                $message_type = "danger";
            }
        } else {
            $logs[] = "ℹ️ Database $database sudah ada.";
        }
        
        // Pilih database
        mysqli_select_db($conn, $database);
        
        // Definisi tabel-tabel
        $tables = [
            'admin' => "CREATE TABLE `admin` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `username` varchar(50) NOT NULL,
                `password` varchar(255) NOT NULL,
                `nama` varchar(100) NOT NULL,
                `email` varchar(100) NOT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `last_login` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `username` (`username`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'visi_misi' => "CREATE TABLE `visi_misi` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `visi` text NOT NULL,
                `misi` text NOT NULL,
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'sambutan_kepsek' => "CREATE TABLE `sambutan_kepsek` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama_kepsek` varchar(100) NOT NULL,
                `foto_kepsek` varchar(255) DEFAULT NULL,
                `sambutan` text NOT NULL,
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'kurikulum' => "CREATE TABLE `kurikulum` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `judul` varchar(255) NOT NULL,
                `deskripsi` text NOT NULL,
                `konten` text NOT NULL,
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'indikator_kelulusan' => "CREATE TABLE `indikator_kelulusan` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `judul` varchar(255) NOT NULL,
                `deskripsi` text NOT NULL,
                `konten` text NOT NULL,
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'prestasi' => "CREATE TABLE `prestasi` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `judul` varchar(255) NOT NULL,
                `deskripsi` text NOT NULL,
                `tanggal` date NOT NULL,
                `tingkat` enum('Sekolah','Kecamatan','Kabupaten','Provinsi','Nasional','Internasional') NOT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'ekstrakurikuler' => "CREATE TABLE `ekstrakurikuler` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama` varchar(100) NOT NULL,
                `deskripsi` text NOT NULL,
                `jadwal` varchar(100) DEFAULT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'fasilitas' => "CREATE TABLE `fasilitas` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama` varchar(100) NOT NULL,
                `deskripsi` text NOT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'galeri' => "CREATE TABLE `galeri` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `judul` varchar(255) NOT NULL,
                `deskripsi` text DEFAULT NULL,
                `foto` varchar(255) NOT NULL,
                `kategori` enum('Kegiatan Pembelajaran','Kegiatan Keagamaan','Ekstrakurikuler','Fasilitas','Lainnya') NOT NULL DEFAULT 'Lainnya',
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'alumni' => "CREATE TABLE `alumni` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama` varchar(100) NOT NULL,
                `tahun_lulus` year(4) NOT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `testimoni` text DEFAULT NULL,
                `pendidikan_lanjutan` varchar(255) DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'artikel' => "CREATE TABLE `artikel` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `judul` varchar(255) NOT NULL,
                `slug` varchar(255) NOT NULL,
                `konten` text NOT NULL,
                `foto` varchar(255) DEFAULT NULL,
                `penulis` varchar(100) NOT NULL,
                `tanggal` date NOT NULL,
                `kategori` enum('Berita','Pengumuman','Artikel','Kegiatan') NOT NULL DEFAULT 'Berita',
                `status` enum('draft','published') NOT NULL DEFAULT 'draft',
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                UNIQUE KEY `slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            
            'pengaturan' => "CREATE TABLE `pengaturan` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama_situs` varchar(100) NOT NULL DEFAULT 'SDIT Luqman Al Hakim Sleman',
                `logo` varchar(255) DEFAULT NULL,
                `alamat` text DEFAULT NULL,
                `telepon` varchar(20) DEFAULT NULL,
                `email` varchar(100) DEFAULT NULL,
                `facebook` varchar(255) DEFAULT NULL,
                `instagram` varchar(255) DEFAULT NULL,
                `youtube` varchar(255) DEFAULT NULL,
                `footer_text` text DEFAULT NULL,
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        ];
        
        // Data awal untuk dimasukkan setelah pembuatan tabel
        $initial_data = [
            'admin' => "INSERT INTO `admin` (`id`, `username`, `password`, `nama`, `email`, `foto`, `last_login`) VALUES
                (1, 'admin', '$2y$10$EfVuZzSzXFsUnRc0gJdNcOUcZxXdmAZQMC8pHjz.HRFQi9WnJUKlO', 'Administrator', 'admin@example.com', NULL, NULL);",
            
            'visi_misi' => "INSERT INTO `visi_misi` (`id`, `visi`, `misi`, `updated_at`) VALUES
                (1, 'Menjadi sekolah Islam terbaik yang menghasilkan generasi Qur''ani yang berakhlak mulia, cerdas, dan mandiri', '<ol><li>Menyelenggarakan pendidikan Islam yang mengintegrasikan aspek keimanan, keilmuan, dan amal sholeh</li><li>Menerapkan pembiasaan akhlak mulia dalam kehidupan sehari-hari</li><li>Mengembangkan pembelajaran yang aktif, kreatif, dan menyenangkan</li><li>Membekali peserta didik dengan keterampilan hidup (life skill)</li></ol>', '2023-01-01 07:00:00');",
            
            'sambutan_kepsek' => "INSERT INTO `sambutan_kepsek` (`id`, `nama_kepsek`, `foto_kepsek`, `sambutan`, `updated_at`) VALUES
                (1, 'Ahmad Fauzi, S.Pd.I', 'kepsek.jpg', 'Assalamualaikum Wr. Wb.\r\n\r\nPuji syukur kami panjatkan ke hadirat Allah SWT atas limpahan rahmat dan karunia-Nya sehingga website SDIT Luqman Al Hakim Sleman dapat hadir di tengah-tengah kita.\r\n\r\nWebsite ini merupakan sarana informasi dan komunikasi bagi seluruh warga sekolah dan masyarakat. Melalui website ini, kami berharap dapat memberikan informasi yang aktual dan terpercaya tentang kegiatan dan program sekolah kami.\r\n\r\nSDIT Luqman Al Hakim Sleman berkomitmen untuk terus meningkatkan kualitas pendidikan yang berbasis Al-Qur''an dan mempersiapkan generasi yang berakhlak mulia, cerdas, dan mandiri.\r\n\r\nWassalamualaikum Wr. Wb.', '2023-01-01 07:00:00');",
            
            'kurikulum' => "INSERT INTO `kurikulum` (`id`, `judul`, `deskripsi`, `konten`, `updated_at`) VALUES
                (1, 'Kurikulum SDIT Luqman Al Hakim Sleman', 'Kurikulum yang diterapkan di SDIT Luqman Al Hakim Sleman merupakan perpaduan antara Kurikulum Nasional dan Kurikulum Kekhasan Sekolah Islam', '<h4>Kurikulum Nasional</h4>\r\n<p>SDIT Luqman Al Hakim Sleman menerapkan Kurikulum Nasional sesuai dengan ketentuan pemerintah yang mencakup mata pelajaran wajib seperti Matematika, Bahasa Indonesia, IPA, IPS, dan lainnya.</p>\r\n\r\n<h4>Kurikulum Kekhasan</h4>\r\n<p>Sebagai sekolah Islam, kami memiliki kurikulum kekhasan yang meliputi:</p>\r\n<ul>\r\n<li>Tahfidz Al-Qur''an</li>\r\n<li>Bahasa Arab</li>\r\n<li>Pendidikan Akhlak</li>\r\n<li>Praktik Ibadah</li>\r\n</ul>', '2023-01-01 07:00:00');",
            
            'indikator_kelulusan' => "INSERT INTO `indikator_kelulusan` (`id`, `judul`, `deskripsi`, `konten`, `updated_at`) VALUES
                (1, 'Indikator Kelulusan SDIT Luqman Al Hakim Sleman', 'Standar kelulusan yang diharapkan dari siswa SDIT Luqman Al Hakim Sleman', '<h4>Aspek Keagamaan</h4>\r\n<ul>\r\n<li>Hafal minimal 2 juz Al-Qur''an</li>\r\n<li>Mampu melaksanakan ibadah wajib dengan baik dan benar</li>\r\n<li>Memiliki akhlak yang baik dalam kehidupan sehari-hari</li>\r\n</ul>\r\n\r\n<h4>Aspek Akademik</h4>\r\n<ul>\r\n<li>Mencapai nilai minimal sesuai standar kelulusan nasional</li>\r\n<li>Mampu berkomunikasi dengan baik</li>\r\n<li>Memiliki kemampuan berpikir kritis dan kreatif</li>\r\n</ul>\r\n\r\n<h4>Aspek Sosial</h4>\r\n<ul>\r\n<li>Mampu bekerja sama dalam tim</li>\r\n<li>Memiliki kepedulian terhadap lingkungan</li>\r\n<li>Memiliki jiwa kepemimpinan</li>\r\n</ul>', '2023-01-01 07:00:00');",
            
            'pengaturan' => "INSERT INTO `pengaturan` (`id`, `nama_situs`, `logo`, `alamat`, `telepon`, `email`, `facebook`, `instagram`, `youtube`, `footer_text`, `updated_at`) VALUES
                (1, 'SDIT Luqman Al Hakim Sleman', 'logo.png', 'Jl. Contoh No. 123, Sleman, Yogyakarta', '08123456789', 'info@luqmanalhakim.sch.id', 'https://facebook.com/sditluqmanalhakim', 'https://instagram.com/sditluqmanalhakim', 'https://youtube.com/sditluqmanalhakim', '© 2023 SDIT Luqman Al Hakim Sleman. All Rights Reserved.', '2023-01-01 07:00:00');"
        ];
        
        // Buat tabel-tabel
        $success_count = 0;
        $error_count = 0;
        
        foreach ($tables as $table_name => $query) {
            // Cek apakah tabel sudah ada
            $result = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
            
            if (mysqli_num_rows($result) == 0) {
                // Tabel belum ada, buat tabel baru
                if (mysqli_query($conn, $query)) {
                    $logs[] = "✅ Tabel '$table_name' berhasil dibuat.";
                    $success_count++;
                    
                    // Masukkan data awal jika tersedia
                    if (isset($initial_data[$table_name])) {
                        if (mysqli_query($conn, $initial_data[$table_name])) {
                            $logs[] = "✅ Data awal untuk tabel '$table_name' berhasil dimasukkan.";
                        } else {
                            $logs[] = "❌ Error saat memasukkan data awal untuk tabel '$table_name': " . mysqli_error($conn);
                            $error_count++;
                        }
                    }
                } else {
                    $logs[] = "❌ Error saat membuat tabel '$table_name': " . mysqli_error($conn);
                    $error_count++;
                }
            } else {
                $logs[] = "ℹ️ Tabel '$table_name' sudah ada.";
            }
        }
        
        // Pesan ringkasan
        if ($error_count == 0) {
            $message = "Migrasi database berhasil dilakukan!";
            $message_type = "success";
        } else {
            $message = "$success_count tabel berhasil dibuat, $error_count tabel gagal dibuat.";
            $message_type = "warning";
        }
        
        // Tutup koneksi
        mysqli_close($conn);
        
        // Buat file database.php jika belum ada
        if (!file_exists('../config/database.php')) {
            $db_config = '<?php
// Konfigurasi Database
$host = \'' . $host . '\';
$username = \'' . $username . '\';
$password = \'' . $password . '\';
$database = \'' . $database . '\';

// Membuat koneksi
$conn = @mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    // Tampilkan pesan error yang lebih informatif
    echo "<div style=\'margin: 20px; padding: 20px; border: 1px solid #dc3545; border-radius: 5px; background-color: #f8d7da; color: #721c24;\'>";
    echo "<h3>Error Koneksi Database</h3>";
    echo "<p><strong>Pesan Error:</strong> " . mysqli_connect_error() . "</p>";
    echo "<p><strong>Kemungkinan Penyebab:</strong></p>";
    echo "<ul>";
    echo "<li>Database \'" . $database . "\' belum dibuat</li>";
    echo "<li>Username atau password database salah</li>";
    echo "<li>Server database tidak berjalan</li>";
    echo "</ul>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ol>";
    echo "<li>Jalankan <a href=\'/profil/Profil_SDIT_Lukmanalhakimsleman/admin/migrate.php\'>migrasi database</a> untuk membuat database dan tabel</li>";
    echo "<li>Periksa konfigurasi database di file config/database.php</li>";
    echo "<li>Jalankan <a href=\'/profil/Profil_SDIT_Lukmanalhakimsleman/config/check_connection.php\'>pengecekan koneksi database</a> untuk diagnosis lebih lanjut</li>";
    echo "</ol>";
    echo "</div>";
    exit;
}

// Set charset ke utf8
mysqli_set_charset($conn, "utf8");
?>';
            
            if (file_put_contents('../config/database.php', $db_config)) {
                $logs[] = "✅ File konfigurasi database berhasil dibuat.";
            } else {
                $logs[] = "❌ Gagal membuat file konfigurasi database.";
                $error_count++;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrasi Database - SDIT Luqman Al Hakim Sleman</title>
    <link rel="shortcut icon" href="../assets/images/x-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
        }
        .migrate-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .log-container {
            max-height: 400px;
            overflow-y: auto;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="migrate-container">
            <div class="logo-container">
                <h2>SDIT Luqman Al Hakim Sleman</h2>
                <h4 class="text-muted">Migrasi Database</h4>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Migrasi Database</h5>
                </div>
                <div class="card-body">
                    <p>Sistem akan membuat database dan tabel-tabel yang diperlukan untuk website SDIT Luqman Al Hakim Sleman jika belum ada.</p>
                    <p><strong>Fitur Migrasi:</strong></p>
                    <ul>
                        <li>Memeriksa apakah database sudah ada sebelum membuatnya</li>
                        <li>Memeriksa apakah tabel-tabel sudah ada sebelum membuatnya</li>
                        <li>Memasukkan data awal untuk tabel-tabel utama</li>
                        <li>Membuat file konfigurasi database jika belum ada</li>
                    </ul>
                    
                    <?php if (!empty($logs)): ?>
                        <div class="log-container">
                            <?php foreach ($logs as $log): ?>
                                <div><?php echo $log; ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Jalankan Migrasi</button>
                            <a href="../admin/" class="btn btn-outline-secondary">Kembali ke Admin Panel</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted">Jika Anda mengalami masalah saat migrasi, silakan hubungi administrator.</p>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html> 