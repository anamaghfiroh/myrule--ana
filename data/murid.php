<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: ../index.php'));
}


include('../config/db.php');
session_start();

if ($_GET['action'] == 'getMurid') {
    $columns = array(
        0 => 'id',
        1 => 'student_name',
        2 => 'login',
        3 => 'student_address',
        4 => 'class_id',
        5 => 'action'
    );

    $sql = "SELECT * FROM student";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    // var_dump($order);
    if (empty($_POST['search']['value'])) {
        // $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        if (!$result) {
            echo mysqli_error($conn);
        }
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM student WHERE student_name like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $query = mysqli_query($conn, "SELECT * FROM class where id = '{$r['class_id']}'");
            $kelas = mysqli_fetch_array($query, MYSQLI_ASSOC);

            $query = mysqli_query($conn, "SELECT login FROM users WHERE id = '{$r['user_id']}'");
            $nis = mysqli_fetch_array($query);
            $nestedData['no'] = $no;
            $nestedData['murid'] = $r["student_name"];
            $nestedData['nis'] = $nis['login'];
            $nestedData['alamat'] = $r['student_address'];
            $nestedData['kelas'] = $kelas['class_name'];
            if ($_SESSION['level_user'] == 1) {
                $nestedData['action'] = "<a href='javascript:void(0)' id='btn-edit' data='{$r['id']}' class='btn btn-warning text-white'><i class='bi bi-pencil-fill'></i></a>
                &emsp;<a href='javascript:void(0)' data='{$r['id']}' id='btn-delete' class='btn btn-danger text-white'><i class='bi bi-trash'></i></a>";
            } else {
                $nestedData['action'] = '';
            }
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    echo json_encode($json_data);
}

if ($_GET['action'] == 'getMuridguru') {
    $columns = array(
        0 => 'id',
        1 => 'student_name',
        2 => 'login',
        3 => 'student_address',
        4 => 'class_id'
    );

    $sql = "SELECT * FROM student";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    // var_dump($order);
    if (empty($_POST['search']['value'])) {
        // $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        if (!$result) {
            echo mysqli_error($conn);
        }
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM student WHERE student_name like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $query = mysqli_query($conn, "SELECT * FROM class where id = '{$r['class_id']}'");
            $kelas = mysqli_fetch_array($query, MYSQLI_ASSOC);

            $query = mysqli_query($conn, "SELECT login FROM users WHERE id = '{$r['user_id']}'");
            $nis = mysqli_fetch_array($query);
            $nestedData['no'] = $no;
            $nestedData['murid'] = $r["student_name"];
            $nestedData['nis'] = $nis['login'];
            $nestedData['alamat'] = $r['student_address'];
            $nestedData['kelas'] = $kelas['class_name'];
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    echo json_encode($json_data);
}

if ($_GET['action'] == 'tambahMurid') {
    //GET POST DATA
    $login = mysqli_real_escape_string($conn, $_POST['nis']);
    $name = mysqli_real_escape_string($conn, $_POST['nama']);
    $address = mysqli_real_escape_string($conn, $_POST['alamat']);
    $class_id = mysqli_real_escape_string($conn, $_POST['kelas']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_pass = password_hash($password, PASSWORD_BCRYPT);

    //INSERT INTO users table
    $register = mysqli_query($conn, "INSERT INTO users (login, password, level_user) VALUES ( '" . $login . "','" . $hashed_pass . "','3' )");
    if (!$register) {
        echo mysqli_error($conn);
    }
    //get registered id
    $result = mysqli_query($conn, "SELECT id FROM users WHERE login = '{$login}'");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //INSERT INTO STUDENT
    $sql = "INSERT INTO student (user_id, nis, student_name, student_address, phone_number, class_id) VALUES('{$row['id']}', '{$login}', '{$name}', '{$address}', '{$phone_number}', '{$class_id}')";
    $insert_student = mysqli_query($conn, $sql);
    if (!$insert_student) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'getMuridById') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM student WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $data = array(
        'id' => $result['id'],
        'nis' => $result['nis'],
        'nama' => $result['student_name'],
        'alamat' => $result['student_address'],
        'no_hp' => $result['phone_number'],
        'kelas' => $result['class_id'],
    );
    echo json_encode($data);
}

if ($_GET['action'] == 'editMurid') {
    $id = $_POST['id'];
    $student_name = $_POST['editNama'];
    $student_address = $_POST['editAlamat'];
    $phone_number = $_POST['edit_no_hp'];
    $class_id = $_POST['editKelas'];
    // var_dump($id);
    $sql = "UPDATE student set student_name = '{$student_name}', student_address = '{$student_address}', phone_number = '{$phone_number}', class_id = '{$class_id}' WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'hapusMurid') {
    $id = $_POST['id'];
    $sql = "SELECT user_id FROM student where id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $query = mysqli_query($conn, "DELETE FROM users WHERE id = '{$user['user_id']}'");
    if (!$query) {
        echo mysqli_error($conn);
    }

    $sql = "DELETE FROM student where id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'getHasilSurvey') {
    $columns = array(
        0 => 'id',
        1 => 'student_name',
        2 => 'login',
        3 => 'student_address',
        4 => 'class_id'
    );

    $sql = "SELECT * FROM student";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    // var_dump($order);
    if (empty($_POST['search']['value'])) {
        // $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        if (!$result) {
            echo mysqli_error($conn);
        }
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM student WHERE student_name like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $query = mysqli_query($conn, "SELECT * FROM class where id = '{$r['class_id']}'");
            $kelas = mysqli_fetch_array($query, MYSQLI_ASSOC);

            $query = mysqli_query($conn, "SELECT login FROM users WHERE id = '{$r['user_id']}'");
            $nis = mysqli_fetch_array($query);

            $query = mysqli_query($conn, "SELECT * FROM survey_result WHERE student_id = '{$r['id']}'");
            if (mysqli_num_rows($query) > 0) {
                $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
                $hasil = $result['level_result'];
            } else {
                $hasil = 'Belum ambil survey';
            }
            $nestedData['no'] = $no;
            $nestedData['murid'] = $r["student_name"];
            $nestedData['nis'] = $nis['login'];
            $nestedData['hasilPreTest'] = $hasil;
            $nestedData['kelas'] = $kelas['class_name'];
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    echo json_encode($json_data);
}

if ($_GET['action'] == 'getMuridPostTest') {
    $columns = array(
        0 => 'id',
        1 => 'student_name',
        2 => 'login',
        3 => 'student_address',
        4 => 'class_id',
        5 => 'action'
    );

    $sql = "SELECT * FROM student";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    // var_dump($order);
    if (empty($_POST['search']['value'])) {
        // $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        $result = mysqli_query($conn, "SELECT * FROM student order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        if (!$result) {
            echo mysqli_error($conn);
        }
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM student WHERE student_name like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $query = mysqli_query($conn, "SELECT * FROM class where id = '{$r['class_id']}'");
            $kelas = mysqli_fetch_array($query, MYSQLI_ASSOC);

            $query = mysqli_query($conn, "SELECT login FROM users WHERE id = '{$r['user_id']}'");
            $nis = mysqli_fetch_array($query);

            $query = mysqli_query($conn, "SELECT * FROM survey_result WHERE student_id = '{$r['id']}'");
            if (mysqli_num_rows($query) > 0) {
                $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
                $hasil = $result['level_result'];
            } else {
                $hasil = 'Belum ambil survey';
            }
            $nestedData['no'] = $no;
            $nestedData['murid'] = $r["student_name"];
            $nestedData['hasilPreTest'] = $hasil;
            if ($_SESSION['level_user'] !=3) {
                $nestedData['action'] = "<a href='hasil-post-test-by.php?id={$r['id']}' id='btn-edit' data='{$r['id']}' class='btn btn-success text-white'>Lihat Hasil Post Test</a>";
            } else {
                $nestedData['action'] = '';
            }
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    echo json_encode($json_data);
}

if ($_GET['action'] == 'getHasilPostTestByMurid') {
    $columns = array(
        0 => 'number',
        1 => 'module_desc',
        2 => 'hasil',
        3 => 'status'
    );

    $student_id = $_POST['id'];

    $sql = "SELECT * FROM module";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];


    if (empty($_POST['search']['value'])) {
        $result = mysqli_query($conn, "SELECT * FROM module order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        // $result = mysqli_query($conn, "SELECT * FROM topic");
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM module WHERE module_desc like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {

            // Check hasil post test
            $sql = "SELECT id,student_id,module_id,MAX(nilai),status FROM nilai_post_test WHERE student_id = '{$student_id}' AND module_id = '{$r['id']}'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);

            $nilai = mysqli_fetch_row($result);
            // var_dump($nilai);
            $nestedData['no'] = $no;
            $nestedData['status'] = $nilai[4];
            $nestedData['module_desc'] = $r["module_desc"];
            if($count> 0){
                $nestedData['hasil'] = $nilai[3];
            }else{
                $nestedData['hasil'] = 'BELUM AMBIL POST TEST';
            }
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    echo json_encode($json_data);
}