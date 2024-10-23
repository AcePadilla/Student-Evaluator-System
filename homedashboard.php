<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="homedashboard.css">
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav>
        <button type="button" id="toggle-btn">
        <i class="fa fa-bars"></i>
        </button>
        <div class="admin">
            <img src="aupics/logo.png">
            <span>Admin</span>
        </div>
        <ul class="sidebar-menu">
        <li><a href="homedashboard.php"><i class="fa-solid fa-chart-line" style="color: white;"></i>Dashboard</a></li>
        <li><a href="teachers.php"><i class="fa-solid fa-glasses" style="color: white;"></i>Teachers</a></li>
        <li><a href="classes.php"><i class="fa-solid fa-chalkboard" style="color: white;"></i>Classes</a></li>
        <li><a href="subjects.php"><i class="fa-solid fa-book-open" style="color: white;"></i>Subjects</a></li>
        <li><a href="student.php"><i class="fa-solid fa-user-group" style="color: white;"></i>Students</a></li>
        <li><a href="enroll_student.php"><i class="fa-solid fa-user-plus" style="color: white;"></i>Enroll Subjects</a></li>
        <li><a href="result.php"><i class="fa-solid fa-square-poll-vertical" style="color: white;"></i>Results</a></li>
        <li> <a href="login.php"><i class="fa-solid fa-right-from-bracket" style="color: white;"></i>Log-out</a></li>
        </ul>
    </nav>
    <section>
        <h2><i class="fa-solid fa-chart-line" style="color:#0081fa;"></i>Dashboard</h2>
        <div class="boxes">
        <?php
            $host = "localhost";
            $database = "ses_db";
            $user = "root";
            $password_db = "";

            $conn = new mysqli($host, $user, $password_db, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $querySubjects = "SELECT COUNT(*) AS totalSubjects FROM subjects";
            $resultSubjects = $conn->query($querySubjects);

            if ($resultSubjects && $rowSubjects = $resultSubjects->fetch_assoc()) {
                $totalSubjects = $rowSubjects['totalSubjects'];
                echo "<a href='subjects.php'><i class='fa-solid fa-book-open' style='color: #ffffff;'></i> Total subjects: $totalSubjects</a>";
            } else {
                echo "<a href='#'><i class='fa-solid fa-book-open' style='color: #ffffff;'></i> Total subjects: Error fetching data</a>";
            }

            $queryStudents = "SELECT COUNT(*) AS totalStudents FROM student";
            $resultStudents = $conn->query($queryStudents);

            if ($resultStudents && $rowStudents = $resultStudents->fetch_assoc()) {
                $totalStudents = $rowStudents['totalStudents'];
                echo "<a href='student.php'><i class='fa-solid fa-user-group' style='color: #ffffff;'></i> Total students: $totalStudents</a>";
            } else {
                echo "<a href='#'><i class='fa-solid fa-user-group' style='color: #ffffff;'></i> Total students: Error fetching data</a>";
            }

            $queryClasses = "SELECT COUNT(*) AS totalClasses FROM classes";
            $resultClasses = $conn->query($queryClasses);

            if ($resultClasses && $rowClasses = $resultClasses->fetch_assoc()) {
                $totalClasses = $rowClasses['totalClasses'];
                echo "<a href='classes.php'><i class='fa-solid fa-chalkboard' style='color: #ffffff;'></i> Total Classes: $totalClasses</a>";
            } else {
                echo "<a href='#'><i class='fa-solid fa-chalkboard' style='color: #ffffff;'></i> Total Classes: Error fetching data</a>";
            }

            $conn->close();
            ?>
        </div>

    </section>
</body>
<script>
    const nav = document.querySelector('nav');
    const toggle_btn = document.getElementById('toggle-btn');
    const content = document.querySelector('section');

    toggle_btn.onclick = function() {
    nav.classList.toggle('hide');
    content.classList.toggle('expand');
    };
</script>

</html>
