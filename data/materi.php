<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: ../index.php'));
}


include('../config/db.php');
session_start();

if ($_GET['action'] == 'getTopik') {
    $columns = array(
        0 => 'number',
        1 => 'topic_desc',
        2 => 'action'
    );

    $sql = "SELECT * FROM topic";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];


    if (empty($_POST['search']['value'])) {
        $result = mysqli_query($conn, "SELECT * FROM topic order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        // $result = mysqli_query($conn, "SELECT * FROM topic");
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM topic WHERE topic_desc like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $nestedData['no'] = $no;
            $nestedData['topic_desc'] = "<a href='subtopik.php?topik={$r['id']}' class='text-decoration-none'>{$r["topic_desc"]}</a>";
            $nestedData['action'] = "<a href='javascript:void(0)' id='btn-edit' data='{$r['id']}' class='btn btn-warning text-white'><i class='bi bi-pencil-fill'></i></a>
            &emsp;<a href='javascript:void(0)' data='{$r['id']}' id='btn-delete' class='btn btn-danger text-white'><i class='bi bi-trash'></i></a>";
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

function getTopicLastNumber($conn)
{
    $sql = "SELECT number FROM topic ORDER BY number DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $number = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $number;
}

if ($_GET['action'] == 'tambahTopik') {
    $topik = $_POST['topik'];
    $number = getTopicLastNumber($conn);
    $number = $number['number'] + 1;
    $sql = "INSERT INTO topic (topic_desc, number) VALUES('{$topik}', '{$number}')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
}

if ($_GET['action'] == 'getTopikById') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM topic WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $data = array(
        'id' => $result['id'],
        'topik' => $result['topic_desc'],
        'no' => $result['number']
    );
    echo json_encode($data);
}

if ($_GET['action'] == 'editTopik') {
    $id = $_POST['id'];
    $topic_desc = $_POST['topik'];
    // var_dump($id);
    $sql = "UPDATE topic set topic_desc = '{$topic_desc}' WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'hapusTopik') {
    $id = $_POST['id'];
    $sql = "DELETE FROM topic where id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}


//SUB TOPIK
if ($_GET['action'] == 'getSubTopik') {
    $columns = array(
        0 => 'number',
        1 => 'sub_topic_desc',
        2 => 'action'
    );
    $id = $_POST['topik'];

    $sql = "SELECT * FROM sub_topic WHERE topic_id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];


    if (empty($_POST['search']['value'])) {
        $result = mysqli_query($conn, "SELECT * FROM sub_topic WHERE topic_id = '{$id}' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        // $result = mysqli_query($conn, "SELECT * FROM topic");
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM sub_topic WHERE topic_id = '{$id}' AND sub_topic_desc like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $nestedData['no'] = $no;
            $nestedData['sub_topic_desc'] = "<a href='modul.php?subtopik={$r['id']}' class='text-decoration-none'>{$r["sub_topic_desc"]}</a>";
            $nestedData['action'] = "<a href='javascript:void(0)' id='btn-edit' data='{$r['id']}' class='btn btn-warning text-white'><i class='bi bi-pencil-fill'></i></a>
            &emsp;<a href='javascript:void(0)' data='{$r['id']}' id='btn-delete' class='btn btn-danger text-white'><i class='bi bi-trash'></i></a>";
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

function getSubTopicLastNumber($conn, $id)
{
    $sql = "SELECT number FROM sub_topic WHERE topic_id = '{$id}' ORDER BY number DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $number = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $number;
}

if ($_GET['action'] == 'tambahSubTopik') {
    $subtopik = $_POST['subtopik'];
    $id = $_POST['topik'];
    $number = getSubTopicLastNumber($conn, $id);
    $number = $number['number'] + 1;
    $sql = "INSERT INTO sub_topic (sub_topic_desc, number, topic_id) VALUES('{$subtopik}', '{$number}', '{$id}')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
}

if ($_GET['action'] == 'getSubTopikById') {
    $id = $_POST['topik'];
    $sql = "SELECT * FROM sub_topic WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $data = array(
        'id' => $result['id'],
        'sub_topik' => $result['sub_topic_desc'],
        'no' => $result['number']
    );
    echo json_encode($data);
}

if ($_GET['action'] == 'editSubTopik') {
    $id = $_POST['id'];
    $sub_topic_desc = $_POST['subtopik'];
    // var_dump($id);
    $sql = "UPDATE sub_topic set sub_topic_desc = '{$sub_topic_desc}' WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'hapusSubTopik') {
    $id = $_POST['id'];
    $sql = "DELETE FROM sub_topic where id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

//MODUL
if ($_GET['action'] == 'getModul') {
    $columns = array(
        0 => 'number',
        1 => 'module_desc',
        2 => 'action'
    );

    $id = $_POST['subtopik'];

    $sql = "SELECT * FROM module WHERE sub_topic_id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];


    if (empty($_POST['search']['value'])) {
        $result = mysqli_query($conn, "SELECT * FROM module WHERE sub_topic_id = '{$id}' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        // $result = mysqli_query($conn, "SELECT * FROM topic");
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM module WHERE sub_topic_id = '{$id}' AND module_desc like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $nestedData['no'] = $no;
            $nestedData['module_desc'] = "<a href='materi.php?module={$r['id']}' class='text-decoration-none'>{$r["module_desc"]}</a>";
            $nestedData['action'] = "<a href='javascript:void(0)' id='btn-edit' data='{$r['id']}' class='btn btn-warning text-white'><i class='bi bi-pencil-fill'></i></a>
            &emsp;<a href='javascript:void(0)' data='{$r['id']}' id='btn-delete' class='btn btn-danger text-white'><i class='bi bi-trash'></i></a>";
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

function getModuleLastNumber($conn, $id)
{
    $sql = "SELECT number FROM module WHERE sub_topic_id = '{$id}' ORDER BY number DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $number = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $number;
}

if ($_GET['action'] == 'tambahModul') {
    $modul = $_POST['modul'];
    $id = $_POST['subtopik'];
    $number = getModuleLastNumber($conn, $id);
    $number = $number['number'] + 1;
    $sql = "INSERT INTO module (module_desc, number, sub_topic_id) VALUES('{$modul}', '{$number}', '{$id}')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
}

if ($_GET['action'] == 'getModulById') {
    $id = $_POST['modul'];
    $sql = "SELECT * FROM module WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $data = array(
        'id' => $result['id'],
        'modul' => $result['module_desc'],
        'no' => $result['number']
    );
    echo json_encode($data);
}

if ($_GET['action'] == 'editModul') {
    $id = $_POST['id'];
    $module_desc = $_POST['modul'];
    // var_dump($id);
    $sql = "UPDATE module set module_desc = '{$module_desc}' WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'hapusModul') {
    $id = $_POST['id'];
    $sql = "DELETE FROM module where id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

//STUDENT MODUL
if ($_GET['action'] == 'getModulByLevel') {
    $columns = array(
        0 => 'number',
        1 => 'module_desc',
        // 2 => 'action'
    );
    $level = $_POST['level'];

    $sql = "SELECT * FROM module WHERE  module_level = '{$level}'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];


    if (empty($_POST['search']['value'])) {
        $result = mysqli_query($conn, "SELECT * FROM module WHERE module_level = '{$level}' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        // $result = mysqli_query($conn, "SELECT * FROM topic");
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM module WHERE module_level = '{$level}' AND module_desc like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $r) {
            $nestedData['no'] = $no;
            $nestedData['module_desc'] = $r["module_desc"];
            // $nestedData['action'] = "<a href='javascript:void(0)' id='btn-edit' data='{$r['id']}' class='btn btn-warning text-white'><i class='bi bi-pencil-fill'></i></a>
            // &emsp;<a href='javascript:void(0)' data='{$r['id']}' id='btn-delete' class='btn btn-danger text-white'><i class='bi bi-trash'></i></a>";
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

//MATERI
if ($_GET['action'] == 'getMateri') {
    $id = $_POST['module'];

    $sql = "SELECT * FROM materi where module_id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    echo json_encode($result);
}

if ($_GET['action'] == 'simpanMateri') {
    $materi = $_POST['materi'];
    $id = $_POST['module'];
    $sql = "INSERT INTO materi (materi_desc, module_id) VALUES('{$materi}', '{$id}')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
}
if ($_GET['action'] == 'updateMateri') {
    $materi = $_POST['materi'];
    $id = $_POST['materi_id'];
    $sql = "UPDATE materi SET materi_desc = '{$materi}' WHERE id='{$id}' ";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
}

//POST TEST
if ($_GET['action'] == 'getModulPostTest') {
    $columns = array(
        0 => 'number',
        1 => 'module_desc',
        2 => 'action'
    );

    // $id = $_POST['subtopik'];

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
            $nestedData['no'] = $no;
            // $nestedData['module_desc'] = "<a href='materi.php?module={$r['id']}' class='text-decoration-none'>{$r["module_desc"]}</a>";
            $nestedData['module_desc'] = $r["module_desc"];
            $nestedData['action'] = "<a href='post-test-q.php?module={$r['id']}' id='btn-question' data='{$r['id']}' class='btn btn-success text-white' title='Edit Pertanyaan Post Test'><i class='bi bi-question-circle'></i></a>";
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

if ($_GET['action'] == 'getPertanyaan') {
    $columns = array(
        0 => 'id',
        1 => 'question',
        2 => 'action'
    );

    $id = $_POST['module'];

    $sql = "SELECT * FROM module_question WHERE module_id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    // echo $order;

    if (empty($_POST['search']['value'])) {
        $result = mysqli_query($conn, "SELECT * FROM module_question WHERE module_id = '{$id}' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM module_question WHERE module_id = '{$id}' AND question like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($row as $r) {
            $nestedData['no'] = $no;
            $nestedData['question'] = $r["question"];
            $nestedData['action'] = "<a href='javascript:void(0)' id='btn-edit' data='{$r['id']}' class='btn btn-warning text-white'><i class='bi bi-pencil-fill'></i></a>
            &emsp;<a href='post-test-qc.php?question={$r['id']}' data='{$r['id']}' class='btn btn-primary text-white' title='Edit Jawaban'><i class='bi bi-list-task'></i></a>
            &emsp;<a href='post-test-qa.php?question={$r['id']}' data='{$r['id']}' class='btn btn-success text-white' title='Edit Kunci Jawaban'><i class='bi bi-key'></i></a>
            &emsp;<a href='javascript:void(0)' data='{$r['id']}' id='btn-delete' class='btn btn-danger text-white'><i class='bi bi-trash'></i></a>";
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

if ($_GET['action'] == 'tambahPertanyaan') {
    $question = $_POST['pertanyaan'];
    $id = $_POST['modul'];
    $sql = "INSERT INTO module_question (module_id, question) VALUES('{$id}', '{$question}')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
}

if ($_GET['action'] == 'hapusPertanyaan') {
    $id = $_POST['id'];
    $sql = "DELETE FROM module_question where id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'getPertanyaanById') {
    $questionId = $_POST['id'];
    $sql = "SELECT * FROM module_question WHERE id = '{$questionId}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $data = array(
        'id' => $result['id'],
        'pertanyaan' => $result['question'],
    );
    echo json_encode($data);
}

if ($_GET['action'] == 'editPertanyaan') {
    $questionId = $_POST['id'];
    $question = $_POST['pertanyaan'];
    // var_dump($id);
    $sql = "UPDATE module_question set question = '{$question}' WHERE id = '{$questionId}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'getJawaban') {
    $columns = array(
        0 => 'id',
        1 => 'question',
        2 => 'action'
    );

    $id = $_POST['pertanyaan'];

    $sql = "SELECT * FROM module_question_choice WHERE question_id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $totalData = $count;
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    // echo $order;

    if (empty($_POST['search']['value'])) {
        // $result = mysqli_query($conn, "SELECT * FROM module_question WHERE question_id = '{$id}' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");
        $result = mysqli_query($conn, "SELECT * FROM module_question_choice WHERE question_id = '{$id}'");
    } else {
        $search = $_POST['search']['value'];
        $result = mysqli_query($conn, "SELECT * FROM module_question_choice WHERE question_id = '{$id}' AND question like '%{$search}%' order by {$order} {$dir} LIMIT {$limit} OFFSET {$start}");

        $count = mysqli_num_rows($result);
        $totalData = $count;
        $totalFiltered = $totalData;
    }

    $data = array();
    if (!empty($result)) {
        $no = $start + 1;
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($row as $r) {
            $nestedData['no'] = $no;
            $nestedData['answer'] = $r["answer_desc"];
            $nestedData['action'] = "<a href='javascript:void(0)' id='btn-edit' data='{$r['id']}' class='btn btn-warning text-white'><i class='bi bi-pencil-fill'></i></a>
            &emsp;<a href='javascript:void(0)' data='{$r['id']}' id='btn-delete' class='btn btn-danger text-white'><i class='bi bi-trash'></i></a>";
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

if ($_GET['action'] == 'tambahJawaban') {
    $answer = $_POST['jawaban'];
    $id = $_POST['pertanyaan'];
    echo $answer;
    $sql = "INSERT INTO module_question_choice (answer_desc,question_id) VALUES('{$answer}', '{$id}')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        echo 'gagal';
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
}

if ($_GET['action'] == 'hapusJawaban') {
    $id = $_POST['id'];
    $sql = "DELETE FROM module_question_choice where id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if ($_GET['action'] == 'getJawabanById') {
    $answerId = $_POST['id'];
    $sql = "SELECT * FROM module_question_choice WHERE id = '{$answerId}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $data = array(
        'id' => $result['id'],
        'jawaban' => $result['answer_desc'],
    );
    echo json_encode($data);
}

if ($_GET['action'] == 'editJawaban') {
    $answerId = $_POST['id'];
    $answer = $_POST['jawaban'];
    // var_dump($id);
    $sql = "UPDATE module_question_choice set answer_desc = '{$answer}' WHERE id = '{$answerId}'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        echo mysqli_error($conn);
    }
}

if($_GET['action'] == 'simpanKunciJawaban'){
    $id = $_POST['idPertanyaan'];
    $answer = $_POST['answer'];
    
    $sql = "UPDATE module_question SET answer = '{$answer}' WHERE id='{$id}' ";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
    } else {
        // $_SESSION['sukses_tambah_topik'] = "Topik baru berhasil disimpan!";
        // header("location: ../admin/topik.php");
    }
    
}