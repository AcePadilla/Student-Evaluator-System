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

    $student_id = $_POST['student_id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $section = $_POST['section'];
    

    $query = "INSERT INTO student (student_id, fname, mname, lname,section) VALUES ('$student_id', '$fname', '$mname', '$lname','$section')";

    if (mysqli_query($conn, $query)) {
        echo "New student record added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
