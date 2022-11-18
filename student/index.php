<?php

include('../config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: ../sign-in.php');
}

if ($_SESSION['level_user'] == 3) {
    $survey = mysqli_query($conn, "SELECT * FROM survey_result where student_id = '{$_SESSION['student_id']}'");
    $survey_row = mysqli_num_rows($survey);
    if ($survey_row == 1) {
        $_SESSION['survey_taken'] = true;
        $level = mysqli_fetch_array($survey, MYSQLI_ASSOC);
        $_SESSION['level'] = $level['level_result'];
    } else {
        $_SESSION['survey_taken'] = false;
    }
}


?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>:: e-Learn:: Education Dashboard </title>
    <link rel="icon" href="../favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <!-- plugin css file  -->
    <link rel="stylesheet" href="../node_modules/owl.carousel2/dist/assets/owl.carousel.min.css" />
    <!-- project css file  -->
    <link rel="stylesheet" href="../assets/css/e-learn.style.min.css">
</head>

<body>

    <div id="elearn-layout" class="theme-purple">
        <!-- sidebar -->
        <?php include('../layout/sidebar.php'); ?>

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            <?php include('../layout/header.php'); ?>

            <!-- Body: Body -->
            <?php if ($_SESSION['level_user'] == 3) { ?>


                            <?php if ($_SESSION['survey_taken']) { ?>
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row clearfix g-3">
                        <div class="col-lg-8 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 bg-info">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-lg-5 order-lg-2">
                                                    <div class="text-center p-4">
                                                        <img src="../assets/images/belajar.png" alt="..." class="img-fluid set-md-img">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-7 order-lg-1">
                                                    <h3 class="h1 m-5">Welcome back, <span class="fw-bold">
                                                            <?php echo $_SESSION['name']; ?>
                                                        </span>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-2 pt-3 bg-info">
                                <h3 class="text-center"><strong>Adaptive Learning</strong></h3>
                                <div class="card-body text-center">
                                    <p class="text-center">Anda Sudah Mengambil Survey</p>
                                    <p class="text-center">Silahkan Ambil Modul yang Sudah Di Rekomendasikan!</p>
                                </div>
                            </div>
                                <?php }else{?>
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row clearfix g-3">
                        <div class="col-lg-8 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 bg-info">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-lg-5 order-lg-2">
                                                    <div class="text-center p-4">
                                                        <img src="../assets/images/belajar.png" alt="..." class="img-fluid set-md-img">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-7 order-lg-1">
                                                    <h3 class="h1 m-5">Welcome, <span class="fw-bold">
                                                            <?php echo $_SESSION['name']; ?>
                                                        </span>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-2 pt-3 bg-info">
                                <h3 class="text-center"><strong>Adaptive Learning</strong></h3>
                                <div class="card-body text-center">
                                    <p class="text-center">Silahkan ambil survey dengan klik tombol</p>
                                    <a href="survey.php" class="btn btn-primary">Survey</a>
                                </div>
                            </div>
                            <div class="card mt-2 pt-3 bg-info">
                                <h3 class="text-center"><strong>E Learning</strong></h3>
                                <div class="card-body text-center">
                                    <p class="text-center">Silahkan Pelajari dan Kerjakan Post Test</p>
                                    <a href="elearn.php" class="btn btn-primary">Modul</a>
                                </div>
                            </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="../assets/bundles/libscripts.bundle.js"></script>

    <!-- Plugin Js-->
    <script src="../node_modules/owl.carousel2/dist/owl.carousel.min.js"></script>
    <script src="../assets/bundles/apexcharts.bundle.js"></script>

    <!-- Jquery Page Js -->
    <script src="../js/template.js"></script>
    <script src="../s/page/elearn-index.js"></script>
</body>

</html>