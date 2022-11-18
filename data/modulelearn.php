<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: ../index.php'));
}


include('../config/db.php');
session_start();

if ($_GET['action'] == 'selesai') {
    $s_id = mysqli_real_escape_string($conn, $_SESSION['student_id']);
    $m_id = mysqli_real_escape_string($conn, $_POST['module']);
    $sql = "INSERT INTO module_learned (module_id, student_id,status_modul) VALUES('{$m_id}', '{$s_id}','e-learn')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("location: ../student/elearn.php");
    } else {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'submitPostTest') {
    $total_soal = 0;
    $jawaban_benar = 0;
    foreach ($_POST as $key => $p) {
        if ($key == 'module') {
        } else {
            $question_id = substr($key, 8);
            $sql = "SELECT * FROM module_question WHERE id = '{$question_id}'";
            $query = mysqli_query($conn, $sql);
            $question = mysqli_fetch_array($query, MYSQLI_ASSOC);
            if ($question['answer'] == $p) {
                $jawaban_benar++;
            }
            $total_soal++;
        }
    }
    $presentasi = $jawaban_benar / $total_soal;
    $s_id = mysqli_real_escape_string($conn, $_SESSION['student_id']);
    $m_id = mysqli_real_escape_string($conn, $_POST['module']);
    $sql = "INSERT INTO module_learned (module_id, student_id,status_modul) VALUES('{$m_id}', '{$s_id}','e-learn')";
    $query = mysqli_query($conn, $sql);    
    $nilai = $presentasi * 100;
    $sql2 = "INSERT INTO nilai_post_test (student_id, nilai, module_id, status) VALUES('{$s_id}', '{$nilai}', '{$m_id}','e-learn')";
    $query2 = mysqli_query($conn, $sql2);
    if ($query && $query2) {
        header("location: ../student/elearn.php");
    } else {
        echo mysqli_error($conn);
    }
}