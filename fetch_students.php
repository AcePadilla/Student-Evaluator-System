<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ses_db";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['section'])) {
        $section = $_GET['section'];

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT student_id, fname, mname, lname FROM student WHERE section = '$section'";

        $result = $conn->query($sql);
        $students = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }

        $conn->close();

        echo json_encode($students); 
    }
}
?>
