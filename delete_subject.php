<?php
$host = "localhost";
$database = "ses_db";
$user = "root";
$password_db = "";

$conn = new mysqli($host, $user, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['subject_code'])) {
    $subjectCode = $_POST['subject_code'];

    $deleteQuery = "DELETE FROM subjects WHERE subject_code = '$subjectCode'";
    if ($conn->query($deleteQuery) === TRUE) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }

    echo json_encode($response);
}

$conn->close();
?>
