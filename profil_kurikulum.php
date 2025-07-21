<?php
// Include database connection
include 'config/database.php';

// Ambil data kurikulum
$query = "SELECT * FROM kurikulum WHERE id = 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan, tampilkan data default
if (!$data) {
    $data = [
        'judul' => 'Kurikulum SDIT Luqman Al Hakim Sleman',
        'deskripsi' => 'Kurikulum yang diterapkan di SDIT Luqman Al Hakim Sleman merupakan perpaduan antara Kurikulum Nasional dan Kurikulum Kekhasan Sekolah Islam',
        'konten' => '<h4>Kurikulum Nasional</h4>
                    <p>SDIT Luqman Al Hakim Sleman menerapkan Kurikulum Nasional sesuai dengan ketentuan pemerintah yang mencakup mata pelajaran wajib seperti Matematika, Bahasa Indonesia, IPA, IPS, dan lainnya.</p>
                    
                    <h4>Kurikulum Kekhasan</h4>
                    <p>Sebagai sekolah Islam, kami memiliki kurikulum kekhasan yang meliputi:</p>
                    <ul>
                    <li>Tahfidz Al-Qur\'an</li>
                    <li>Bahasa Arab</li>
                    <li>Pendidikan Akhlak</li>
                    <li>Praktik Ibadah</li>
                    </ul>'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurikulum - SDIT Luqman Al Hakim Sleman</title>
    <link rel="shortcut icon" href="assets/images/x-icon.png" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/swiper.min.css">
    <link rel="stylesheet" href="assets/css/lightcase.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader ending here -->


    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop yellow-color"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->


    <!-- menu-search-form start here -->
    <div class="menu-search-form">
        <form>
          <input type="text" name="search" placeholder="Search here...">
          <button type="submit"><i class="icofont-search"></i></button>
        </form>
    </div>
    <!-- menu-search-form ending here -->

    <!-- header section start here -->
    <?php include 'header.php'; ?>
    <!-- header section ending here -->

    <!-- Page Header Section Start Here -->
    <section class="page-header-section style-1">
        <div class="container">
            <div class="page-header-content">
                <div class="page-header-inner">
                    <div class="page-title">
                        <h2>Kurikulum</h2>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Kurikulum</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- course section start here -->
    <div class="course-single-section padding-tb section-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="main-part">
                        <div class="course-item">
                            <div class="course-inner">
                                <div class="course-content">
                                    <h3><?php echo $data['judul']; ?></h3>
                                    <p><?php echo $data['deskripsi']; ?></p>
                                    
                                    <?php echo $data['konten']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- course section ending here -->

    <!-- footer -->
    <?php include 'footer.php'; ?>
    <!-- footer -->



    <!-- All Scripts -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/progress.js"></script>
    <script src="assets/js/lightcase.js"></script>
    <script src="assets/js/counter-up.js"></script>
    <script src="assets/js/isotope.pkgd.js"></script>
    <script src="assets/js/functions.js"></script>
</body>
</html> 