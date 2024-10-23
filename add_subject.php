<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "ses_db";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $subject_code = $_POST['subject_code'];
    $subject_description = $_POST['subject_description'];

    $query = "INSERT INTO subjects (subject_code, subject_description) VALUES ('$subject_code', '$subject_description')";

    $response = array();
    if (mysqli_query($conn, $query)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
