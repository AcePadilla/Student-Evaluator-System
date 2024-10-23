<?php
$conn = mysqli_connect("localhost", "root", "", "ses_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_id = $_GET["student_id"];
$student_name = "";
$section = "";
$enrollments = [];
$gpa = "";
$comments = "";

$student_query = "SELECT * FROM student WHERE student_id='$student_id'";
$student_result = mysqli_query($conn, $student_query);

if ($student = mysqli_fetch_assoc($student_result)) {
    $student_name = $student["fname"] . " " . $student["mname"] . " " . $student["lname"];
    $section = $student["section"];
}

$enrolled_subjects_query = "SELECT enrollments.*, subjects.subject_description FROM enrollments JOIN subjects ON enrollments.subject_code = subjects.subject_code WHERE enrollments.student_id='$student_id'";
$enrolled_subjects_result = mysqli_query($conn, $enrolled_subjects_query);
$enrollments = [];

while ($row = mysqli_fetch_assoc($enrolled_subjects_result)) {
    $enrollments[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gpa_sum = 0;
    $any_fail = false;

    foreach ($enrollments as $key => $enrollment) {
        $subject_code = $enrollment["subject_code"];
        
        $field_name = str_replace(" ", "_", $subject_code);
        
        $prelim_grade = (float)$_POST["prelim_grade_$field_name"];
        $midterm_grade = (float)$_POST["midterm_grade_$field_name"];
        $final_grade = (float)$_POST["final_grade_$field_name"];

        $average_grade = ($prelim_grade + $midterm_grade + $final_grade) / 3;
        $gpa_sum += $average_grade;

        $remarks = ($average_grade >= 50) ? "Pass" : "Failed";
        if ($remarks == "Failed") {
            $any_fail = true;
        }
        $enrollments[$key]["prelim_grade"] = $prelim_grade;
        $enrollments[$key]["midterm_grade"] = $midterm_grade;
        $enrollments[$key]["final_grade"] = $final_grade;
        $enrollments[$key]["average"] = $average_grade;
        $enrollments[$key]["remarks"] = $remarks;

        $update_query = "UPDATE enrollments SET prelim_grade='$prelim_grade', midterm_grade='$midterm_grade', final_grade='$final_grade', average='$average_grade', remarks='$remarks' WHERE student_id='$student_id' AND subject_code='$subject_code'";
        if (!mysqli_query($conn, $update_query)) {
            echo "Error updating grades for subject $subject_code: " . mysqli_error($conn) . "<br>";
        }
    }

    $gpa = $gpa_sum / count($enrollments);
    $comments = ($any_fail) ? "Not eligible for enrollment next semester" : "Eligible for enrollment next semester";

    $check_query = "SELECT * FROM result WHERE student_id='$student_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $update_result_query = "UPDATE result SET GPA='$gpa', comments='$comments' WHERE student_id='$student_id'";
    } else {
        $update_result_query = "INSERT INTO result (student_id, GPA, comments) VALUES ('$student_id', '$gpa', '$comments')";
    }

    if (!mysqli_query($conn, $update_result_query)) {
        echo "Error updating result for student: " . mysqli_error($conn) . "<br>";
    } else {
        echo "<script>alert('Grades and GPA updated successfully!');</script>";
    }   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE,edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="homedashboard.css">
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        header {
            background-color: #0081fa;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        h1 {
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #0081fa;
            color: white;
        }
        input[type="number"] {
            width: 60px;
            text-align: center;
        }
        input[type="number"][readonly] {
            background-color: #f2f2f2;
        }
        form {
            margin: 20px 0;
        }
        input[type="submit"] {
            background-color: #0081fa;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .button-link {
            float: right;
            display: inline-block;
            padding: 8px 20px;
            background-color: #0081fa;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1><?= $student_name ?> (<?= $student_id ?>)</h1>
        <p>Section: <?= $section ?></p>
    </header>
    <div class="container">
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Prelim Grade</th>
                        <th>Midterm Grade</th>
                        <th>Final Grade</th>
                        <th>Average</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr>
                            <td><?= $enrollment["subject_code"] ?> - <?= $enrollment["subject_description"] ?></td>
                            <td><input type="number" name="prelim_grade_<?= $enrollment["subject_code"] ?>" value="<?= $enrollment["prelim_grade"] ?>" required></td>
                            <td><input type="number" name="midterm_grade_<?= $enrollment["subject_code"] ?>" value="<?= $enrollment["midterm_grade"] ?>" required></td>
                            <td><input type="number" name="final_grade_<?= $enrollment["subject_code"] ?>" value="<?= $enrollment["final_grade"] ?>" required></td>
                            <td><input type="number" name="average_<?= $enrollment["subject_code"] ?>" value="<?= $enrollment["average"] ?>" readonly></td>
                            <td><?= $enrollment["remarks"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <input type="submit" value="Update Grades">
            <a href="result.php?student_id=<?= $student_id ?>" class="button-link">Back to Results</a>
        </form>
        <h3>GPA: <?= $gpa ?></h3>
        <p><?= $comments ?></p>
    </div>
</body>
</html>
