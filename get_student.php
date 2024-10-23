<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "ses_db";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT student_id, fname, mname, lname, section FROM student";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>Student ID</th><th>First Name</th><th>Middle Name</th><th>Last Name</th<th>Section</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['student_id'] . '</td>';
        echo '<td>' . $row['fname'] . '</td>';
        echo '<td>' . $row['mname'] . '</td>';
        echo '<td>' . $row['lname'] . '</td>';
        echo '<td>' . $row['section'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'No records found.';
}

mysqli_close($conn);
?>
