<?php

include('../config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: ../sign-in.php');
}

$id = $_GET['question'];

$sql = "SELECT * FROM module_question WHERE id = '{$id}'";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_array($query, MYSQLI_ASSOC);

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
                    <h2>Kunci Jawaban</h2>
                    <div class="row clearfix g-3 mt-3">
                        <div class="col-lg-8 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 bg-info">
                                        <div class="card-body p-4">
                                            <div class="alert alert-success" role="alert">
                                                <h4>PERTANYAAN : </h4>
                                                <?php 
                                                echo $result['question'];
                                                ?>
                                            </div>
                                            <div class="d-flex justify-content-end mb-3">
                                                <a href="post-test-q.php?module=<?php echo $result['module_id'] ?>"
                                                    class="btn btn-info text-white  "><i
                                                        class="icofont-arrow-left"></i>&nbsp;Kembali</a>
                                            </div>
                                            <div class=" row align-items-center">
                                                <!-- <table id="jawabanTable"
                                                    class="table table-bordered table-striped bg-white"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Jawaban</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                </table> -->
                                                <b>Pilih jawaban yang benar :</b>
                                                <form action="../data/materi.php?action=simpanKunciJawaban"
                                                    method="POST" id="formSimpanKunciJawaban">
                                                    <input type="hidden" name="idPertanyaan" value="<?php echo $id ?>">
                                                    <?php
                                                        $sql = "SELECT * FROM module_question_choice WHERE question_id = '{$id}'";
                                                        $query = mysqli_query($conn, $sql);
                                                        $answer = mysqli_fetch_all($query, MYSQLI_ASSOC);
                                                        foreach ($answer as $key => $a) { ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="answer"
                                                            value="<?php echo $a['id'] ?>" required
                                                            <?php if($a['id'] == $result['answer']) { echo 'checked';} ?>>

                                                        <label class="form-check-label"
                                                            for="tipeguru1"><?php echo $a['answer_desc'] ?></label>
                                                    </div>
                                                    <?php }
                                                        ?>
                                                    <div class="my-3 px-3">
                                                        <button type="submit" id="saveMateriButton"
                                                            class="btn btn-success">SIMPAN</button>
                                                    </div>
                                                </form>
                                            </div>
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

    <script>
    var table;
    $(document).ready(function() {
        $('#formSimpanKunciJawaban').submit(function() {
            $.ajax({
                url: "../data/materi.php?action=simpanKunciJawaban",
                method: "POST",
                data: $('#formSimpanKunciJawaban').serialize(),
                success: function(data) {
                    Swal.fire(
                        '',
                        'Sukses Simpan Kunci Jawaban',
                        'success'
                    );
                },
                error: function(e) {
                    console.log(e)
                }
            })
            return false;
        })

        $('#jawabanTable').on('click', '#btn-edit', function() {
            $.ajax({
                url: "../data/materi.php?action=getJawabanById",
                method: "post",
                type: "ajax",
                data: {
                    id: $(this).attr('data'),
                },
                dataType: "json",
                success: function(data) {
                    $('#jawabanEdit').val(data['jawaban']);
                    $('#idJawaban').val(data['id']);
                },
                error: function(e) {
                    console.log(e);
                }
            })
            $('#modalEditJawaban').modal('show');
        })

        $('#formEditJawaban').submit(function() {
            $.ajax({
                url: '../data/materi.php?action=editJawaban',
                method: "post",
                type: "ajax",
                data: {
                    id: $('#idJawaban').val(),
                    jawaban: $('#jawabanEdit').val()
                },
                success: function(data) {
                    Swal.fire(
                        '',
                        'Update Jawaban Berhasil',
                        'success'
                    );
                    table.ajax.reload();
                    $('#modalEditJawaban').modal('hide');
                },
                error: function(e) {
                    console.log(e);
                }
            });
            return false;
        })

        $('#jawabanTable').on('click', '#btn-delete', function() {
            Swal.fire({
                title: "Konfirmasi Hapus Jawaban?!",
                text: "Apakah anda yakin untuk manghapus data jawaban ini?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Ya!',
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../data/materi.php?action=hapusJawaban',
                        method: 'post',
                        type: 'ajax',
                        data: {
                            id: $(this).attr('data')
                        },
                        success: function(data) {
                            Swal.fire(
                                '',
                                'Hapus Jawaban Berhasil',
                                'success'
                            );
                            table.ajax.reload();
                            $('#modalEditJawaban').modal('hide');
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    })
                } else {
                    Swal.fire(
                        'Cancelled',
                        'Hapus Jawaban Dibatalkan',
                        'error'
                    );
                }
            })
        })
    });
    </script>
</body>

</html>