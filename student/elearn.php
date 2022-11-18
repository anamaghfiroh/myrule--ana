<?php

include('../config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: ../sign-in.php');
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
                    <h2>E-Learning Modul</h2>
                    <div class="row clearfix g-3 mt-3">
                        <div class="col-lg-12 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 bg-info">
                                        <div class="card-body p-5">
                                            <div class="row">
                                            <?php
                                                        $sql = "SELECT * FROM module";
                                                        $query= mysqli_query($conn, $sql);
                                                        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
                                                        $sql1 = "SELECT * FROM module_learned WHERE student_id = '{$_SESSION['student_id']}' AND status_modul='e-learn'";
                                                        $query1 = mysqli_query($conn, $sql1);
                                                        $result1 = mysqli_fetch_all($query1, MYSQLI_ASSOC);
                                                        $module = array();
                                                        $module_desc = array();
                                                        $module_learned = array();
                                                        foreach ($result as $key => $r) {
                                                            array_push($module, $r['id']);
                                                            array_push($module_desc, $r['module_desc']);
                                                        }
                                                        foreach ($result1 as $key => $r) {
                                                            array_push($module_learned, $r['module_id']);
                                                        }
                                                        $a = count($module);
                                                        $b = count($module_learned);
                                                        for ($i=0; $i <$a-1 ; $i++) { 
                                                            $count = 0;
                                                            $cek = false;
                                                            while ( $b > $count) {
                                                                if ($module[$i]==$module_learned[$count]) {
                                                                    $cek = true;
                                                                    $count=$b+1;
                                                                }
                                                                $count++;
                                                            }
                                                            if ($cek){ ?>
                                                                    <div class="col-md-3">
                                                                        <a href="modulelearn.php?module=<?php echo $module[$i] ?>" class="text-decoration-none">
                                                                            <div class="card modul mb-3 <?php echo "bg-success text-white";?>">
                                                                                <div class="card-body">
                                                                                    <div class="card-title">
                                                                                        <span>Modul<?php echo $module[$i]; ?></span>
                                                                                        <span><</i><i class="bi bi-check-circle"></i></span>
                                                                                    </div>
                                                                                    <div class="card-text fw-bold">
                                                                                        <span><?php echo $module_desc[$i]; ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                <?php }else{ ?> 
                                                                        <div class="col-md-3">
                                                                        <a href="modulelearn.php?module=<?php echo $module[$i] ?>" class="text-decoration-none">
                                                                            <div class="card modul mb-3 <?php echo "text-black";?>">
                                                                                <div class="card-body">
                                                                                    <div class="card-title">
                                                                                        <span>Modul<?php echo $module[$i]; ?></span>
                                                                                    </div>
                                                                                    <div class="card-text fw-bold">
                                                                                        <span><?php echo $module_desc[$i]; ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                       <?php }
                                                   }
                                                   ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix g-3 mt-3">
                                <div class="card mb-3 bg-info">
                                    <div class="card-body p-5">
                                        <div class="col-11 offset-1">
                                            <a href="./post_test_final.php?module=<?php echo 8; ?>" class="btn btn-success col-md-12">POST TEST AKHIR</a>
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