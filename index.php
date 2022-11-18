<?php

include('config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: sign-in.php');
} else {
    if ($_SESSION['level_user'] == 1) {
        header('location: admin/index.php');
    } else if ($_SESSION['level_user'] == 2) {
        header('location: guru/index.php');
    } else {
        header('location: student/index.php');
    }
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