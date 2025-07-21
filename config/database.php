<?php
// Konfigurasi Database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_sdit_lukmanalhakimsleman';

// Membuat koneksi
$conn = @mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    // Tampilkan pesan error yang lebih informatif
    echo "<div style='margin: 20px; padding: 20px; border: 1px solid #dc3545; border-radius: 5px; background-color: #f8d7da; color: #721c24;'>";
    echo "<h3>Error Koneksi Database</h3>";
    echo "<p><strong>Pesan Error:</strong> " . mysqli_connect_error() . "</p>";
    echo "<p><strong>Kemungkinan Penyebab:</strong></p>";
    echo "<ul>";
    echo "<li>Database '$database' belum dibuat</li>";
    echo "<li>Username atau password database salah</li>";
    echo "<li>Server database tidak berjalan</li>";
    echo "</ul>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ol>";
    echo "<li>Jalankan <a href='/profil/Profil_SDIT_Lukmanalhakimsleman/admin/migrate.php'>migrasi database</a> untuk membuat database dan tabel</li>";
    echo "<li>Periksa konfigurasi database di file config/database.php</li>";
    echo "<li>Jalankan <a href='/profil/Profil_SDIT_Lukmanalhakimsleman/config/check_connection.php'>pengecekan koneksi database</a> untuk diagnosis lebih lanjut</li>";
    echo "</ol>";
    echo "</div>";
    exit;
}

// Set charset ke utf8
mysqli_set_charset($conn, "utf8");
?> 