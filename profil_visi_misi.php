<?php
// Include database connection
include 'config/database.php';

// Ambil data visi misi
$query = "SELECT * FROM visi_misi WHERE id = 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan, tampilkan data default
if (!$data) {
    $data = [
        'visi' => 'Mewujudkan Generasi Qur\'ani yang Cerdas, Berakhlak Mulia, dan Mandiri',
        'misi' => '<ul>
                    <li>Menyelenggarakan pendidikan dasar Islam yang mampu menghasilkan lulusan yang berakhlak mulia, cinta Al-Qur\'an, dan memiliki kemampuan akademik yang optimal</li>
                    <li>Menyelenggarakan pendidikan dasar Islam yang mampu membekali siswa dengan pengetahuan dan keterampilan dasar yang dibutuhkan untuk melanjutkan ke jenjang pendidikan yang lebih tinggi</li>
                    <li>Menyelenggarakan pendidikan dasar Islam yang mampu menghasilkan lulusan yang mandiri dan memiliki semangat juang tinggi</li>
                    <li>Menyelenggarakan pendidikan dasar Islam yang mampu menghasilkan lulusan yang memiliki keberanian, ketangguhan, dan mampu berkompetisi secara global</li>
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
    <title>Visi Misi - SDIT Luqman Al Hakim Sleman</title>
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
                        <h2>Visi Misi</h2>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Visi Misi</li>
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
                                    <h3>Visi</h3>
                                    <p><?php echo $data['visi']; ?></p>
                                    <h4>Misi</h4>
                                    <?php echo $data['misi']; ?>
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