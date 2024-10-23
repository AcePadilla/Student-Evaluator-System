<?php
include 'dbconnect.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location:student_login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

$host = "localhost";
$database = "ses_db";
$user = "root";
$password_db = "";

$query = "SELECT 
    enrollments.subject_code, 
    enrollments.prelim_grade, 
    enrollments.midterm_grade, 
    enrollments.final_grade, 
    enrollments.average, 
    enrollments.remarks,
    student.fname,
    student.mname,
    student.lname,
    student.section
FROM enrollments
JOIN student ON enrollments.student_id = student.student_id
WHERE enrollments.student_id = '$student_id'";

$result = $conn->query($query);
$enrollment_details = $result->fetch_all(MYSQLI_ASSOC);

$query = "SELECT GPA, comments FROM result WHERE student_id = '$student_id'";
$result = $conn->query($query);
$gpa_and_comments = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE, edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="style.css">
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <title>Student View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #0077b6;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #0077b6;
            color: #fff;
        }

        button {
            background-color: #0077b6;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top:8px;
        }

        button:hover {
            background-color: #005691;
        }
        .back-button {
            background-color: #0077b6;
            color: #fff;
            border: none;
            padding: 9px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            float:right;
        }

        .back-button i {
            margin-right: 5px;
        }

        .back-button:hover {
            background-color: #005691;
        }
        @media print {
            body {
                background-color: #fff; 
            }
            .back-button {
                display: none;
            }

            .container {
                max-width: 100%; 
                margin: 0;
                padding: 20px;
                box-shadow: none; 
                page-break-after: auto;
            }

            h2 {
                background-color: transparent; 
                color: #000;
                padding: 10px 0; 
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                border: 1px solid #000; 
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: transparent; 
                color: #000; 
            }

            button {
                display: none; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Details</h2>
        <p>Student ID: <?php echo $student_id; ?></p>
        <p>First Name: <?= $enrollment_details[0]['fname'] ?></p>
        <p>Middle Name: <?= $enrollment_details[0]['mname'] ?></p>
        <p>Last Name: <?= $enrollment_details[0]['lname'] ?></p>
        <p>Section: <?= $enrollment_details[0]['section'] ?></p>

        <h2>Evaluation Sheet</h2>
<table>
    <tr>
        <th>Subject Code</th>
        <th>Prelim Grade</th>
        <th>Midterm Grade</th>
        <th>Final Grade</th>
        <th>Average</th>
        <th>Remarks</th>
    </tr>
    <?php
    $subjectGrades = array(); 
    foreach ($enrollment_details as $detail):
        $subjectCode = $detail['subject_code'];
        if (!isset($subjectGrades[$subjectCode])):
            $subjectGrades[$subjectCode] = true;
    ?>
    <tr>
        <td><?= $subjectCode ?></td>
        <td><?= $detail['prelim_grade'] ?></td>
        <td><?= $detail['midterm_grade'] ?></td>
        <td><?= $detail['final_grade'] ?></td>
        <td><?= $detail['average'] ?></td>
        <td><?= $detail['remarks'] ?></td>
    </tr>
    <?php endif; ?>
    <?php endforeach; ?>
</table>

        <h2>Result</h2>
        <p><strong>GPA:</strong> <?php echo $gpa_and_comments['GPA']; ?></p>
        <p><strong>Comments:</strong> <?php echo $gpa_and_comments['comments']; ?></p>

        <button onclick="printPage()"><i class="fa fa-print"></i> Print</button>
        <a href="student_login.php" class="back-button"><i class="fa fa-arrow-left"></i> Back to Login</a>
    </div>

    <script type="text/javascript">
        function printPage() {
            window.print();
        }
    </script>
</body>
</html>
