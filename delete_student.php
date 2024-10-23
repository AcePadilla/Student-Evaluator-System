<?php
$host = "localhost";
$database = "ses_db";
$user = "root";
$password_db = "";

$conn = new mysqli($host, $user, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['student_id'])) {
    $studentId = $_POST['student_id'];

    $deleteQuery = "DELETE FROM student WHERE student_id = '$studentId'";
    if ($conn->query($deleteQuery) === TRUE) {
        $response = "Student deleted successfully";
    } else {
        $response = "Error: " . $conn->error;
    }

    echo $response;
}

$conn->close();
?>
