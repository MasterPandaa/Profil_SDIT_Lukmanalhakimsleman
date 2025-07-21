<?php
// Include database connection
include 'config/database.php';

// Ambil data ekstrakurikuler
$query = "SELECT * FROM ekstrakurikuler ORDER BY nama ASC";
$result = mysqli_query($conn, $query);
$ekstrakurikulers = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ekstrakurikulers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler - SDIT Luqman Al Hakim Sleman</title>
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
                        <h2>Ekstrakurikuler</h2>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Ekstrakurikuler</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- course section start here -->
    <div class="course-section padding-tb section-bg">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">Pengembangan Bakat dan Minat</span>
                <h2 class="title">Ekstrakurikuler SDIT Luqman Al Hakim Sleman</h2>
                <p>Program ekstrakurikuler untuk mengembangkan potensi, bakat, dan minat siswa-siswi SDIT Luqman Al Hakim Sleman</p>
            </div>
            <div class="section-wrapper">
                <div class="row g-4 justify-content-center">
                    <?php if (count($ekstrakurikulers) > 0): ?>
                        <?php foreach ($ekstrakurikulers as $ekskul): ?>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="course-item">
                                    <div class="course-inner">
                                        <div class="course-thumb">
                                            <?php if (!empty($ekskul['foto'])): ?>
                                                <img src="assets/images/ekstrakurikuler/<?php echo htmlspecialchars($ekskul['foto']); ?>" alt="<?php echo htmlspecialchars($ekskul['nama']); ?>">
                                            <?php else: ?>
                                                <img src="assets/images/course/01.jpg" alt="ekstrakurikuler">
                                            <?php endif; ?>
                                        </div>
                                        <div class="course-content">
                                            <div class="course-category">
                                                <div class="course-cate">
                                                    <a href="#">Ekstrakurikuler</a>
                                                </div>
                                                <div class="course-reiew">
                                                    <span class="ratting">
                                                        <i class="icofont-ui-calendar"></i> <?php echo htmlspecialchars($ekskul['jadwal'] ?? 'Jadwal Menyesuaikan'); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <a href="#"><h4><?php echo htmlspecialchars($ekskul['nama']); ?></h4></a>
                                            <div class="course-details">
                                                <div class="couse-count"><i class="icofont-info-circle"></i> <?php echo substr(strip_tags($ekskul['deskripsi']), 0, 150); ?>...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Belum ada data ekstrakurikuler.</p>
                        </div>
                    <?php endif; ?>
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