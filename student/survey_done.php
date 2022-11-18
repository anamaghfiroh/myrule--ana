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
        $_SESSION['levels'] = $survey;
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
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row clearfix g-3">
                        <div class="col-lg-8 col-md-12 flex-column">
                            <?php if ($_SESSION['level_user'] == 3) { ?>


                            <div class="card mb-3 color-bg-200">
                                <div class="card-header py-3">
                                    <h3 class="mb-0 fw-bold ">Anda Telah Selesai mengambil survey. Silahkan masuk ke
                                        menu modul.</h3>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-0 fw-bold">
                                        <a href="modul.php" class="btn btn-primary">MODUL</a>
                                    </h6>
                                </div>
                            </div>
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