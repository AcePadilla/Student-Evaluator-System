<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectCode = $_POST["subject_code"];
    $newSubjectDescription = $_POST["new_subject_description"];

    $host = "localhost";
    $database = "ses_db";
    $user = "root";
    $password_db = "";

    $conn = new mysqli($host, $user, $password_db, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE subjects SET subject_description = ? WHERE subject_code = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ss", $newSubjectDescription, $subjectCode);

    if ($stmt->execute()) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo "Invalid request method";
}
?>
