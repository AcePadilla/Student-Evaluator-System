<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE, edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="homedashboard.css">
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 2px solid #ddd;
        border-right: 2px solid #ddd;
    }

    th {
        background-color: #0081fa;
        color: white;
    }

    th:first-child,
    td:first-child {
        border-left: 2px solid #ddd;
    }

    .mark-button {
        background-color: #0AC160;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 5px;
    }
    .mark-button:hover{
        background-color: #029C4A;
    }
    .edit-button {
        background-color: #0081fa;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 5px;
        text-decoration: none;
    }

    .edit-button:hover {
        background-color: #0056b3;
    }
</style>
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
        <h2><i class="fa-solid fa-square-poll-vertical" style="color:#0081fa;"></i>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
    <th>Full Name</th>
    <th>Section</th>
    <th>GPA</th>
    <th>Comment</th>
    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               <?php 
                $conn = mysqli_connect("localhost", "root", "", "ses_db");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT 
        student.student_id, fname, mname, lname, section, GPA, 
        comments
    FROM student
    LEFT JOIN result ON student.student_id = result.student_id;";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $studentName = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
    echo "<td>" . $studentName . "</td>";
    echo "<td>" . $row['section'] . "</td>";
    echo "<td>" . $row['GPA'] . "</td>";
    echo "<td>" . $row['comments'] . "</td>";
 
    echo "<td><a class='edit-button' href='edit_result.php?student_id=" . $row['student_id'] . "'>Edit</a></td>";
    echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No students found</td></tr>";
                }

                mysqli_close($conn);;
?>
            </tbody>
        </table>
        
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
