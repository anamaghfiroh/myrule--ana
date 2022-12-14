<?php

include('../config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: ../sign-in.php');
}

if (isset($_SESSION['level'])) {
    $level_user = $_SESSION['level'];
    if ($level_user == 1) {
        $level_modul = [1, 2, 3];
    } else if ($level_user == 2) {
        $level_modul = [2, 3, 1];
    } else {
        $level_modul = [3, 1, 2];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="../assets/css/style.css?v=<?php echo date("yymmdd") ?>" rel="stylesheet" />
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
            <div class="body d-flex py-lg-2 py-md-2">
                <div class="container-fluid">
                    <h2>Adaptive Learning Modul</h2>
                    <div class="row clearfix g-3 mt-3">
                        <div class="col-lg-12 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 bg-info">
                                        <div class="card-body p-5">

                                            <?php
                                            if (isset($_SESSION['gagal_post_test'])) { ?>
                                            <div class="alert alert-danger" role="alert">
                                                ANDA GAGAL LULUS POST TEST. SILAHKAN ULANGI KEMBALI.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            <?php }

                                            unset($_SESSION['gagal_post_test']);

                                            if (isset($level_modul)) {
                                                foreach ($level_modul as $l) { ?>

                                            <div class="row">
                                                <?php

                                                        $sql = "SELECT * FROM module WHERE module_level = '{$l}'";
                                                        $query = mysqli_query($conn, $sql);
                                                        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
                                                        $last_key = 0;
                                                        $last_learned = 0;
                                                        foreach ($result as $key => $r) {
                                                            $disabled = false;
                                                            $module_learned = false;
                                                            if ($l == $level_user) {
                                                                if ($key == array_key_first($result)) {
                                                                    $disabled = false;
                                                                } else {
                                                                    $sql = "SELECT * FROM module_learned WHERE student_id = '{$_SESSION['student_id']}' AND status_modul='adaptive learning' order by id DESC limit 1";
                                                                    $query = mysqli_query($conn, $sql);
                                                                    if (mysqli_num_rows($query) > 0) {
                                                                        $modul = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                                                        if ($modul['module_id'] == $last_key) {
                                                                            $disabled = false;
                                                                        } else {
                                                                            $sql = "SELECT * FROM module_learned WHERE student_id = '{$_SESSION['student_id']}' AND module_id = '{$last_key}' AND status_modul='adaptive learning'";
                                                                            $query = mysqli_query($conn, $sql);
                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                $disabled = false;
                                                                            } else {
                                                                                $disabled = true;
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $disabled = true;
                                                                    }
                                                                }
                                                            } else if ($l < $level_user) {
                                                                $disable = false;
                                                            } else {
                                                                if (isset($level_done)) {
                                                                    if ($level_done == ($l - 1)) {
                                                                        if ($key == array_key_first($result)) {
                                                                            $disabled = false;
                                                                        } else {
                                                                            $sql = "SELECT * FROM module_learned WHERE student_id = '{$_SESSION['student_id']}' AND status_modul='adaptive learning' order by id DESC limit 1";
                                                                            $query = mysqli_query($conn, $sql);
                                                                            $modul = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                                                            if ($modul['module_id'] == $last_key) {
                                                                                $disabled = false;
                                                                            } else {
                                                                                $sql = "SELECT * FROM module_learned WHERE student_id = '{$_SESSION['student_id']}' AND module_id = '{$last_key}' AND status_modul='adaptive learning'";
                                                                                $query = mysqli_query($conn, $sql);
                                                                                if (mysqli_num_rows($query) > 0) {
                                                                                    $disabled = false;
                                                                                } else {
                                                                                    $disabled = true;
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $disabled = true;
                                                                    }
                                                                } else {
                                                                    $disabled = true;
                                                                }
                                                            }

                                                            $last_key = $r['id'];
                                                            $sql = "SELECT * FROM module_learned WHERE student_id = '{$_SESSION['student_id']}' AND module_id = '{$r['id']}' AND status_modul='adaptive learning'";
                                                            $query = mysqli_query($conn, $sql);
                                                            if (mysqli_num_rows($query) > 0) {
                                                                $module_learned = true;
                                                            }

                                                            if ($key == array_key_last($result) && $module_learned == true) {
                                                                $level_done = $l;
                                                            }


                                                        ?>

                                                <div class="col-md-3">
                                                    <a href="module.php?module=<?php echo $r['id'] ?>"
                                                        class="text-decoration-none <?php if ($disabled) { ?>disabled-link<?php } ?>">
                                                        <div class="card modul mb-3 <?php if ($disabled) {
                                                                                                    echo "bg-dark text-white";
                                                                                                } else if ($module_learned) {
                                                                                                    echo "bg-success text-white";
                                                                                                } else {
                                                                                                    echo "text-black";
                                                                                                } ?>">
                                                            <div class="card-body">
                                                                <div class="card-title">
                                                                    <span>Modul
                                                                        <?php echo $r['number']; ?></span>
                                                                    <span><?php if ($disabled) { ?><i
                                                                            class="bi bi-lock"></i><?php } else if ($module_learned) { ?>
                                                                        <i class="bi bi-check-circle"></i>
                                                                        <?php } ?></span>
                                                                </div>
                                                                <div class="card-text fw-bold">
                                                                    <span><?php echo $r['module_desc'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <hr />
                                            <?php } ?>
                                            <div class="row clearfix g-3 mt-3">
                                                <div class="card mb-3 bg-info">
                                                    <div class="card-body p-5">
                                                        <div class="col-11 offset-1">
                                                            <a href="./post_test_final.php?module=<?php echo 8; ?>" class="btn btn-success col-md-12">POST TEST AKHIR</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php    } else { ?>
                                            <h1>ANDA BELUM MENGAMBIL SURVEY</h1>
                                            <a href="index.php" class="btn btn-primary">KEMBALI KE HOME</a>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>

        </div>
    </div>

    <!-- Jquery Core Js -->
    <!-- <script src="../assets/bundles/libscripts.bundle.js"></script> -->

    <!-- Plugin Js-->
    <!-- <script src="../node_modules/owl.carousel2/dist/owl.carousel.min.js"></script>
    <script src="../assets/bundles/apexcharts.bundle.js"></script> -->

    <!-- Jquery Page Js -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/page/elearn-index.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>