<?php

include('../config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: ../sign-in.php');
}

$id = $_GET['module'];

$sql = "SELECT * FROM module WHERE id = '{$id}'";
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
                    <h2>Pertanyaan Post Test Modul <b><?php echo $result['module_desc'] ?></b></h2>
                    <div class="row clearfix g-3 mt-3">
                        <div class="col-lg-8 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 bg-info">
                                        <div class="card-body p-5">
                                            <div class="d-flex justify-content-between mb-3">
                                                <a href="tambah-pertanyaan.php" class="btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#modalTambahPertanyaan"><i
                                                        class="icofont-plus"></i>&nbsp;Tambah
                                                    Pertanyaan</a>
                                                <a href="post-test.php" class="btn btn-info text-white  "><i
                                                        class="icofont-arrow-left"></i>&nbsp;Kembali</a>
                                            </div>
                                            <div class=" row align-items-center">
                                                <table id="pertanyaanTable"
                                                    class="table table-bordered table-striped bg-white"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Pertanyaan</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                </table>
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

    <!-- Modal Tambah Pertanyaan -->
    <div class="modal fade" id="modalTambahPertanyaan" tabindex="-1" aria-labelledby="modalTambahPertanyaanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="../data/materi.php?action=tambahPertanyaan" method="POST" id="formTambahPertanyaan">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPertanyaanLabel">Tambah Pertanyaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <input type="hidden" name="modul" id="modul" value="<?php echo $id ?>" />
                            <label for="pertanyaan" class="col-sm-2 col-form-label">Pertanyaan</label>
                            <div class="col-sm-10">
                                <!-- <input type="text" class="form-control" name="pertanyaan" required> -->
                                <textarea name="pertanyaan" id="pertanyaan" class="mb-3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pertanyaan -->
    <div class="modal fade" id="modalEditPertanyaan" tabindex="-1" aria-labelledby="modalEditPertanyaanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="../data/materi.php?action=editPertanyaan" method="POST" id="formEditPertanyaan">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPertanyaanLabel">Edit Pertanyaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idPertanyaan" value="" />
                        <div class="mb-3 row">
                            <label for="pertanyaan" class="col-sm-2 col-form-label">Pertanyaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pertanyaanEdit" name="pertanyaanEdit"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info text-white">Simpan</button>
                    </div>
                </form>
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
    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>

    <script>
    var table;
    $(document).ready(function() {
        //CKEDITOR.replace('pertanyaan');
        table = $('#pertanyaanTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "../data/materi.php?action=getPertanyaan",
                "data": {
                    module: <?php echo $id ?>,
                },
                "dataType": "json",
                "type": "POST",
            },
            "columnDefs": [ //Set column definition initialisation properties.
                {
                    "targets": [0, 2], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "columns": [{
                    data: "no",
                    name: "no"
                },
                {
                    data: "question",
                    name: "question"
                },
                {
                    data: "action",
                    name: "action"
                }
            ]
        });

        $('#formTambahPertanyaan').submit(function() {
            $.ajax({
                url: "../data/materi.php?action=tambahPertanyaan",
                method: "POST",
                data: {
                    modul: $('#modul').val(),
                    pertanyaan: CKEDITOR.instances.pertanyaan.getData()
                },
                success: function(data) {
                    Swal.fire(
                        '',
                        'Sukses Tambah Pertanyaan',
                        'success'
                    );
                    table.ajax.reload();
                    $('#modalTambahPertanyaan').modal('hide');
                },
                error: function(e) {
                    console.log(e)
                }
            })
            $('#formTambahPertanyaan')[0].reset();
            CKEDITOR.instances.pertanyaan.setData('');
            return false;
        })

        $('#pertanyaanTable').on('click', '#btn-edit', function() {
            $.ajax({
                url: "../data/materi.php?action=getPertanyaanById",
                method: "post",
                type: "ajax",
                data: {
                    id: $(this).attr('data'),
                },
                dataType: "json",
                success: function(data) {
                    $('#pertanyaanEdit').val(data['pertanyaan']);
                    $('#idPertanyaan').val(data['id']);
                },
                error: function(e) {
                    console.log(e);
                }
            })
            $('#modalEditPertanyaan').modal('show');
        })

        $('#formEditPertanyaan').submit(function() {
            $.ajax({
                url: '../data/materi.php?action=editPertanyaan',
                method: "post",
                type: "ajax",
                data: {
                    id: $('#idPertanyaan').val(),
                    pertanyaan: $('#pertanyaanEdit').val()
                },
                success: function(data) {
                    Swal.fire(
                        '',
                        'Update Pertanyaan Berhasil',
                        'success'
                    );
                    table.ajax.reload();
                    $('#modalEditPertanyaan').modal('hide');
                },
                error: function(e) {
                    console.log(e);
                }
            });
            return false;
        })

        $('#pertanyaanTable').on('click', '#btn-delete', function() {
            Swal.fire({
                title: "Konfirmasi Hapus Pertanyaan?!",
                text: "Apakah anda yakin untuk manghapus data pertanyaan ini?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Ya!',
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../data/materi.php?action=hapusPertanyaan',
                        method: 'post',
                        type: 'ajax',
                        data: {
                            id: $(this).attr('data')
                        },
                        success: function(data) {
                            Swal.fire(
                                '',
                                'Hapus Pertanyaan Berhasil',
                                'success'
                            );
                            table.ajax.reload();
                            $('#modalEditPertanyaan').modal('hide');
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    })
                } else {
                    Swal.fire(
                        'Cancelled',
                        'Hapus Pertanyaan Dibatalkan',
                        'error'
                    );
                }
            })
        })
    });
    </script>
</body>

</html>