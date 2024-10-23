<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="student.css">
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>
<style>

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    td{
        font-size:14px;
    }
    th {
        background-color: #f2f2f2;
        font-size:18px;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .delete-button {
        background-color: rgb(255, 18, 18);
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: block;
        margin: 0 auto;
    }
    .delete-button:hover {
        background-color: rgb(135, 0, 0);
        transition: ease-in-out 0.2s;
    }
    .button {
        position: relative;
        width: 150px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        border: 1px solid #0081fa;
        background-color: #0081fa;
        }

        .button, .button__icon, .button__text {
        transition: all 0.3s;
        }

        .button .button__text {
        transform: translateX(30px);
        color: #fff;
        font-weight: 600;
        }

        .button .button__icon {
        position: absolute;
        transform: translateX(109px);
        height: 100%;
        width: 39px;
        background-color: #0081fa;
        display: flex;
        align-items: center;
        justify-content: center;
        }

        .button .svg {
        width: 30px;
        stroke: white;
        }

        .button:hover {
        background: #0081fa;
        }

        .button:hover .button__text {
        color: transparent;
        }

        .button:hover .button__icon {
        width: 148px;
        transform: translateX(0);
        }

        .button:active .button__icon {
        background-color: #0081fa;
        }

        .button:active {
        border: 1px solid #0081fa;
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
            <li><a href="login.php"><i class="fa-solid fa-right-from-bracket" style="color: white;"></i>Log-out</a></li>
        </ul>
    </nav>
    <section>
        <h2><i class="fa-solid fa-user-group" style="color:#0081fa;"></i>Students</h2>

        <button type="button" id="addNewButton" class="button">
        <span class="button__text">Add New</span>
        <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
        </button>

        <form id="addNewForm" style="display: none;">
            <input type="text" name="student_id" placeholder="Student ID" required>
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="mname" placeholder="Middle Name" required>
            <input type="text" name="lname" placeholder="Last Name" required>
            <select name="section" required>
                <option value="" disabled selected>Select Section</option>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "ses_db";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT section FROM classes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["section"] . '">' . $row["section"] . '</option>';
                    }
                } else {
                    echo '<option value="" disabled selected>No sections available</option>';
                }

                $conn->close();
                ?>
            </select>
            <button type="submit">Save</button>
        </form>
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
            echo '<tr><th>Student ID</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Section</th><th>Action</th></tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['student_id'] . '</td>';
                echo '<td>' . $row['fname'] . '</td>';
                echo '<td>' . $row['mname'] . '</td>';
                echo '<td>' . $row['lname'] . '</td>';
                echo '<td>' . $row['section'] . '</td>';    
                echo '<td><button class="delete-button" data-studentid="' . $row['student_id'] . '">Delete</button></td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No records found.';
        }
        mysqli_close($conn);
        ?>
    </section>
</body>
<script>
const nav = document.querySelector('nav');
const toggle_btn = document.getElementById('toggle-btn');
const content = document.querySelector('section');
const addNewButton = document.getElementById('addNewButton');
const addNewForm = document.getElementById('addNewForm');
const studentTable = document.querySelector('table');

toggle_btn.onclick = function() {
    nav.classList.toggle('hide');
    content.classList.toggle('expand');
};

addNewButton.onclick = function() {
    addNewForm.style.display = 'block';
};

addNewForm.onsubmit = function(e) {
    e.preventDefault();

    const formData = new FormData(addNewForm);

    fetch('insert_student.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        addNewForm.reset();
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
};

document.addEventListener('click', function (event) {
    if (event.target.classList.contains('delete-button')) {
        const studentId = event.target.getAttribute('data-studentid');
        
        if (confirm('Are you sure you want to delete this student?')) {
            fetch('delete_student.php', {
                method: 'POST',
                body: new URLSearchParams({ student_id: studentId }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Student deleted successfully") {
                    location.reload();
                } else {
                    console.error('Error:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
});
</script>
</html>
