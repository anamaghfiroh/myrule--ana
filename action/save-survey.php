<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: ../index.php'));
}


include('../config/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // MENGHITUNG LEVEL KETERTARIKAN

    // Deklarasi variable ketertarikan
    $levelkt = 0;
    $kt1 = $_POST['question1'];
    $kt2 = $_POST['question2'];
    $kt3 = $_POST['question3'];
    $kt4 = $_POST['question4'];
    $kt5 = $_POST['question5'];

    // Mulai hitung level ketertarikan

    if ($kt1 == 1 && $kt2 == 1 && $kt2 == 1 && $kt3 == 1 && $kt4 == 1 && $kt5 == 1) { // 1
        $levelkt = 3;
    } elseif ($kt1 == 1 && $kt2 == 1 && $kt3 == 1 && $kt4 == 1 && $kt5 == 0) { // 2
        $levelkt = 3;
    } elseif ($kt1 == 1 && $kt2 == 1 && $kt3 == 1 && $kt4 == 0 && $kt5 == 0) { // 3
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 1 && $kt3 == 0 && $kt4 == 0 && $kt5 == 0) { // 4
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 0 && $kt4 == 0 && $kt5 == 0) { // 5
        $levelkt = 1;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 1 && $kt4 == 1 && $kt5 == 1) { // 6
        $levelkt = 3;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 1 && $kt4 == 1 && $kt5 == 1) { // 7
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 0 && $kt4 == 1 && $kt5 == 1) { // 8
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 0 && $kt4 == 0 && $kt5 == 1) { // 9
        $levelkt = 1;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 0 && $kt4 == 0 && $kt5 == 0) { // 10
        $levelkt = 1;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 1 && $kt4 == 1 && $kt5 == 1) { // 11
        $levelkt = 3;
    } elseif ($kt1 == 1 && $kt2 == 1 && $kt3 == 0 && $kt4 == 1 && $kt5 == 1) { // 12
        $levelkt = 3;
    } elseif ($kt1 == 1 && $kt2 == 1 && $kt3 == 1 && $kt4 == 0 && $kt5 == 1) { // 13
        $levelkt = 3;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 0 && $kt4 == 1 && $kt5 == 1) { // 14
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 1 && $kt3 == 0 && $kt4 == 0 && $kt5 == 1) { // 15
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 0 && $kt4 == 0 && $kt5 == 1) { // 16
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 1 && $kt4 == 1 && $kt5 == 0) { // 17
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 1 && $kt4 == 0 && $kt5 == 1) { // 18
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 0 && $kt4 == 1 && $kt5 == 0) { // 19
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 1 && $kt4 == 0 && $kt5 == 0) { // 20
        $levelkt = 1;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 0 && $kt4 == 0 && $kt5 == 0) { // 21
        $levelkt = 1;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 0 && $kt4 == 1 && $kt5 == 0) { // 22
        $levelkt = 1;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 1 && $kt4 == 0 && $kt5 == 0) { // 23
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 1 && $kt4 == 1 && $kt5 == 0) { // 24
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 1 && $kt4 == 0 && $kt5 == 1) { // 25
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 0 && $kt3 == 1 && $kt4 == 0 && $kt5 == 1) { // 26
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 1 && $kt3 == 0 && $kt4 == 1 && $kt5 == 0) { // 27
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 0 && $kt4 == 1 && $kt5 == 1) { // 28
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 1 && $kt4 == 1 && $kt5 == 0) { // 29
        $levelkt = 2;
    } elseif ($kt1 == 0 && $kt2 == 1 && $kt3 == 0 && $kt4 == 0 && $kt5 == 1) { // 30
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 1 && $kt4 == 0 && $kt5 == 0) { // 31
        $levelkt = 2;
    } elseif ($kt1 == 1 && $kt2 == 0 && $kt3 == 0 && $kt4 == 1 && $kt5 == 0) { // 32
        $levelkt = 2;
    }

    // MENGHITUNG LEVEL KETERLIBATAN

    // Deklarasi variable keterlibatan
    $levelkb = 0;
    $kb1 = $_POST['question1'];
    $kb2 = $_POST['question2'];
    $kb3 = $_POST['question3'];
    $kb4 = $_POST['question4'];
    $kb5 = $_POST['question5'];

    // Mulai hitung level keterlibatan

    if ($kb1 == 1 && $kb2 == 1 && $kb2 == 1 && $kb3 == 1 && $kb4 == 1 && $kb5 == 1) { // 1
        $levelkb = 3;
    } elseif ($kb1 == 1 && $kb2 == 1 && $kb3 == 1 && $kb4 == 1 && $kb5 == 0) { // 2
        $levelkb = 3;
    } elseif ($kb1 == 1 && $kb2 == 1 && $kb3 == 1 && $kb4 == 0 && $kb5 == 0) { // 3
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 1 && $kb3 == 0 && $kb4 == 0 && $kb5 == 0) { // 4
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 0 && $kb4 == 0 && $kb5 == 0) { // 5
        $levelkb = 1;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 1 && $kb4 == 1 && $kb5 == 1) { // 6
        $levelkb = 3;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 1 && $kb4 == 1 && $kb5 == 1) { // 7
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 0 && $kb4 == 1 && $kb5 == 1) { // 8
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 0 && $kb4 == 0 && $kb5 == 1) { // 9
        $levelkb = 1;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 0 && $kb4 == 0 && $kb5 == 0) { // 10
        $levelkb = 1;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 1 && $kb4 == 1 && $kb5 == 1) { // 11
        $levelkb = 3;
    } elseif ($kb1 == 1 && $kb2 == 1 && $kb3 == 0 && $kb4 == 1 && $kb5 == 1) { // 12
        $levelkb = 3;
    } elseif ($kb1 == 1 && $kb2 == 1 && $kb3 == 1 && $kb4 == 0 && $kb5 == 1) { // 13
        $levelkb = 3;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 0 && $kb4 == 1 && $kb5 == 1) { // 14
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 1 && $kb3 == 0 && $kb4 == 0 && $kb5 == 1) { // 15
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 0 && $kb4 == 0 && $kb5 == 1) { // 16
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 1 && $kb4 == 1 && $kb5 == 0) { // 17
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 1 && $kb4 == 0 && $kb5 == 1) { // 18
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 0 && $kb4 == 1 && $kb5 == 0) { // 19
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 1 && $kb4 == 0 && $kb5 == 0) { // 20
        $levelkb = 1;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 0 && $kb4 == 0 && $kb5 == 0) { // 21
        $levelkb = 1;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 0 && $kb4 == 1 && $kb5 == 0) { // 22
        $levelkb = 1;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 1 && $kb4 == 0 && $kb5 == 0) { // 23
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 1 && $kb4 == 1 && $kb5 == 0) { // 24
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 1 && $kb4 == 0 && $kb5 == 1) { // 25
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 0 && $kb3 == 1 && $kb4 == 0 && $kb5 == 1) { // 26
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 1 && $kb3 == 0 && $kb4 == 1 && $kb5 == 0) { // 27
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 0 && $kb4 == 1 && $kb5 == 1) { // 28
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 1 && $kb4 == 1 && $kb5 == 0) { // 29
        $levelkb = 2;
    } elseif ($kb1 == 0 && $kb2 == 1 && $kb3 == 0 && $kb4 == 0 && $kb5 == 1) { // 30
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 1 && $kb4 == 0 && $kb5 == 0) { // 31
        $levelkb = 2;
    } elseif ($kb1 == 1 && $kb2 == 0 && $kb3 == 0 && $kb4 == 1 && $kb5 == 0) { // 32
        $levelkb = 2;
    }

    // HITUNG LEVEL MATERI SISWA

    $level = 0;

    if ($levelkt == 1 && $levelkb == 1) { // 1
        $level = 1;
    } elseif ($levelkt == 3 && $levelkb == 3) { // 2
        $level = 3;
    } elseif ($levelkt == 1 && $levelkb == 2) { // 3
        $level = 2;
    } elseif ($levelkt == 1 && $levelkb == 3) { // 4
        $level = 2;
    } elseif ($levelkt == 2 && $levelkb == 1) { // 5
        $level = 2;
    } elseif ($levelkt == 2 && $levelkb == 2) { // 6
        $level = 2;
    } elseif ($levelkt == 2 && $levelkb == 3) { // 7
        $level = 3;
    } elseif ($levelkt == 3 && $levelkb == 1) { // 8
        $level = 2;
    } elseif ($levelkt == 3 && $levelkb == 2) { // 9
        $level = 3;
    }


    $result = mysqli_query($conn, "INSERT INTO survey_result (level_result, student_id) VALUES ('{$level}', '{$_SESSION['student_id']}')");
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        header('Location: ../student/survey_done.php');
        exit();
    }
}