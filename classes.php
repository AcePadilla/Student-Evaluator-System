<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aupics/logo.png">
    <link rel="stylesheet" href="classes.css">
    <link rel="stylesheet" href="classes.css"> 
    <title>Student Evaluator System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/aed89df169.js" crossorigin="anonymous"></script>
</head>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 5px;
        width: 50%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .close {
        color: #888;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }

    .modal-content h2 {
        font-size: 24px;
        margin: 0;
        padding: 0;
    }

    #studentList {
        list-style: none;
        padding: 0;
    }

    #studentList li {
        margin-bottom: 5px;
        font-size: 16px;
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
        <h2><i class="fa-solid fa-chalkboard" style="color:#0081fa;"></i>Classes</h2>
        <div class="teachers">
            <ul>
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
                        echo "<li><a href='javascript:void(0);' onclick='openModal(\"" . $row["section"] . "\")'><i class='fa-solid fa-chalkboard' style='color: white;'></i>" . $row["section"] . "</a></li>";
                    }
                } else {
                    echo "No sections found in the database.";
                }

                $conn->close();
                ?>
            </ul>
        </div>
    </section>

    <div class="modal" id="studentModal">
        <div class="modal-content">
            <span class="close" id="modalClose">&times;</span>
            <h2>Students in this section</h2>
            <ul id="studentList">
            </ul>
        </div>
    </div>

    <script>
        const nav = document.querySelector('nav');
        const toggle_btn = document.getElementById('toggle-btn');
        const content = document.querySelector('section');

        toggle_btn.onclick = function () {
            nav.classList.toggle('hide');
            content.classList.toggle('expand');
        };

        function openModal(section) {
            const modal = document.getElementById('studentModal');
            const studentList = document.getElementById('studentList');

            fetch('fetch_students.php?section=' + section)
                .then(response => response.json())
                .then(data => {
                    studentList.innerHTML = ''; 
                    data.forEach(student => {
                        const li = document.createElement('li');
                        li.textContent = `${student.student_id} - ${student.fname} ${student.mname} ${student.lname}`;
                        studentList.appendChild(li);
                    });

                    modal.style.display = 'block'; 
                })
                .catch(error => {
                    console.error('Error fetching student data:', error);
                });
        }

        const modalClose = document.getElementById('modalClose');
        modalClose.onclick = function () {
            const modal = document.getElementById('studentModal');
            modal.style.display = 'none';
        }
    </script>
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